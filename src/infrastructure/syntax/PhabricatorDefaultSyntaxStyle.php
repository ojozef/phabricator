<?php

final class PhabricatorDefaultSyntaxStyle
  extends PhabricatorSyntaxStyle {

  const STYLEKEY = 'default';

  public function getStyleName() {
    return pht('Default');
  }

  public function getStyleMap() {
    return array(
      'hll' => 'color: #ffffcc',
      'c' => 'color: #74777d',
      'cm' => 'color: #74777d',
      'c1' => 'color: #74777d',
      'cs' => 'color: #74777d',
      'sd' => 'color: #000000',
      'sh' => 'color: #000000',
      's' => 'color: #d5b35d',
      'sb' => 'color: #d5b35d',
      'sc' => 'color: #d5b35d',
      's2' => 'color: #d5b35d',
      's1' => 'color: #d5b35d',
      'sx' => 'color: #d5b35d',
      'sr' => 'color: #bb6688',
      'nv' => 'color: #001294',
      'vi' => 'color: #001294',
      'vg' => 'color: #001294',
      'na' => 'color: #354bb3',
      'kc' => 'color: #48B9FA',
      'no' => 'color: #48B9FA',
      'k' => 'color: #4194D3',
      'kd' => 'color: #bb66bb',
      'kn' => 'color: #bb66bb',
      'kt' => 'color: #4194D3',
      'cp' => 'color: #304a96',
      'kp' => 'color: #304a96',
      'kr' => 'color: #304a96',
      'nb' => 'color: #304a96',
      'bp' => 'color: #304a96',
      'nc' => 'color: #00702a',
      'nt' => 'color: #00702a',
      'vc' => 'color: #00702a',
      'nf' => 'color: #004012',
      'nx' => 'color: #004012',
      'o' => 'color: #8abeb7',
      'ss' => 'color: #aa2211',
      'm' => 'color: #de935f',
      'mf' => 'color: #de935f',
      'mh' => 'color: #de935f',
      'mi' => 'color: #de935f',
      'mo' => 'color: #de935f',
      'il' => 'color: #de935f',
      'gd' => 'color: #a00000',
      'gr' => 'color: #ff0000',
      'gh' => 'color: #000080',
      'gi' => 'color: #00a000',
      'go' => 'color: #808080',
      'gp' => 'color: #000080',
      'gu' => 'color: #800080',
      'gt' => 'color: #0040d0',
      'nd' => 'color: #8abeb7',
      'ni' => 'color: #92969d',
      'ne' => 'color: #d2413a',
      'nl' => 'color: #98D4F7',
      'nn' => 'color: #0000ff',
      'ow' => 'color: #aa22ff',
      'w' => 'color: #bbbbbb',
      'se' => 'color: #bb6622',
      'si' => 'color: #bb66bb',
    );
  }

}
