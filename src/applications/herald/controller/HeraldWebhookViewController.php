<?php

final class HeraldWebhookViewController
  extends HeraldWebhookController {

  public function shouldAllowPublic() {
    return true;
  }

  public function handleRequest(AphrontRequest $request) {
    $viewer = $this->getViewer();

    $hook = id(new HeraldWebhookQuery())
      ->setViewer($viewer)
      ->withIDs(array($request->getURIData('id')))
      ->executeOne();
    if (!$hook) {
      return new Aphront404Response();
    }

    $header = $this->buildHeaderView($hook);

    $warnings = null;
    if ($hook->isInErrorBackoff($viewer)) {
      $message = pht(
        'Many requests to this webhook have failed recently (at least %s '.
        'errors in the last %s seconds). New requests are temporarily paused.',
        $hook->getErrorBackoffThreshold(),
        $hook->getErrorBackoffWindow());

      $warnings = id(new PHUIInfoView())
        ->setSeverity(PHUIInfoView::SEVERITY_WARNING)
        ->setErrors(
          array(
            $message,
          ));
    }

    $curtain = $this->buildCurtain($hook);
    $properties_view = $this->buildPropertiesView($hook);

    $timeline = $this->buildTransactionTimeline(
      $hook,
      new HeraldWebhookTransactionQuery());
    $timeline->setShouldTerminate(true);

    $requests = id(new HeraldWebhookRequestQuery())
      ->setViewer($viewer)
      ->withWebhookPHIDs(array($hook->getPHID()))
      ->setLimit(20)
      ->execute();

    $requests_table = id(new HeraldWebhookRequestListView())
      ->setViewer($viewer)
      ->setRequests($requests)
      ->setHighlightID($request->getURIData('requestID'));

    $requests_view = id(new PHUIObjectBoxView())
      ->setHeaderText(pht('Recent Requests'))
      ->setBackground(PHUIObjectBoxView::BLUE_PROPERTY)
      ->setTable($requests_table);

    $hook_view = id(new PHUITwoColumnView())
      ->setHeader($header)
      ->setMainColumn(
        array(
          $warnings,
          $properties_view,
          $requests_view,
          $timeline,
        ))
      ->setCurtain($curtain);

    $crumbs = $this->buildApplicationCrumbs()
      ->addTextCrumb(pht('Webhook %d', $hook->getID()))
      ->setBorder(true);

    return $this->newPage()
      ->setTitle(
        array(
          pht('Webhook %d', $hook->getID()),
          $hook->getName(),
        ))
      ->setCrumbs($crumbs)
      ->setPageObjectPHIDs(
        array(
          $hook->getPHID(),
        ))
      ->appendChild($hook_view);
  }

  private function buildHeaderView(HeraldWebhook $hook) {
    $viewer = $this->getViewer();

    $title = $hook->getName();

    $header = id(new PHUIHeaderView())
      ->setHeader($title)
      ->setViewer($viewer)
      ->setPolicyObject($hook)
      ->setHeaderIcon('fa-cloud-upload');

    return $header;
  }


  private function buildCurtain(HeraldWebhook $hook) {
    $viewer = $this->getViewer();
    $curtain = $this->newCurtainView($hook);

    $can_edit = PhabricatorPolicyFilter::hasCapability(
      $viewer,
      $hook,
      PhabricatorPolicyCapability::CAN_EDIT);

    $id = $hook->getID();
    $edit_uri = $this->getApplicationURI("webhook/edit/{$id}/");
    $test_uri = $this->getApplicationURI("webhook/test/{$id}/");

    $curtain->addAction(
      id(new PhabricatorActionView())
        ->setName(pht('Edit Webhook'))
        ->setIcon('fa-pencil')
        ->setDisabled(!$can_edit)
        ->setWorkflow(!$can_edit)
        ->setHref($edit_uri));

    $curtain->addAction(
      id(new PhabricatorActionView())
        ->setName(pht('New Test Request'))
        ->setIcon('fa-cloud-upload')
        ->setDisabled(!$can_edit)
        ->setWorkflow(true)
        ->setHref($test_uri));

    return $curtain;
  }


  private function buildPropertiesView(HeraldWebhook $hook) {
    $viewer = $this->getViewer();

    $properties = id(new PHUIPropertyListView())
      ->setViewer($viewer);

    $properties->addProperty(
      pht('URI'),
      $hook->getWebhookURI());

    $properties->addProperty(
      pht('Status'),
      $hook->getStatusDisplayName());

    return id(new PHUIObjectBoxView())
      ->setHeaderText(pht('Details'))
      ->setBackground(PHUIObjectBoxView::BLUE_PROPERTY)
      ->appendChild($properties);
  }

}
