<?php
/*
Element Description: VC Info Box
*/

// Element Class
class vcInfo extends WPBakeryShortCode {

  // Element Init
  function __construct() {
    add_action( 'init', array( $this, 'vc_info_mapping' ) );
    add_shortcode( 'vc_info', array( $this, 'vc_info_html' ) );
  }

  // Element Mapping
  public function vc_info_mapping() {

    // Stop all if VC is not enabled
    if ( !defined( 'WPB_VC_VERSION' ) ) {
      return;
    }
    // Map the block with vc_map()
    vc_map(array(
      'name'=>__('Comparison Table Product','motor-child'),
      'base'=>'vc_info',
      'description'=>__('Add Comparison Table to Product'),
      'class'=>'mainSlider',
      'show_settings_on_create'=>true,
      'weight'=>10,
      'category'=>__('Structure'),
      'group'=>__('Partes Miami AP'),
      'icon'=>WP_PLUGIN_DIR.'/ebay-importer-giorgiosaud/public/img/zonapro.png',
      'params'=>array(
        array(
          'type' => 'textfield',
          'holder' => 'h2',
          'class' => 'section-header',
          'heading' => __( 'Cantidad de Items Por Pagina' ),
          'param_name' => 'qty',
          'value' => 5,
          'description' => __( 'Cantidad de Items Por Pagina', 'baquedano' ),
          'admin_label' => false,
          'weight' => 0,
          'group' => 'Partes Miami AP',
        ),

      ),
    ));
  }


  // Element HTML
  public function vc_info_html( $atts ) {
    extract(shortcode_atts(array(
      'qty'=>5
    ),$atts));
    $table = get_field( 'compatible_table' );
    $output_string='';
    if ( $table ) {


      ob_start();

      if ( $table['header'] ) {
        ?>
        <thead>
          <tr>
            <?php foreach ($table['header'] as $th) {
              ?>
              <th>
                <?= $th['c'] ?>
              </th>


            <?php } ?>
            </tr>
            <?php } ?>
            <tbody>
              <?php foreach ( $table['body'] as $tr ) {?>
                <tr>
                  <?php foreach ( $tr as $td ) {?>

                    <td>
                      <?= $td['c'];?>
                    </td>
                    <?php
                  }
                  ?>
                </tr>
                <?php
              }?>

            </tbody>
          </table>

          <?php

          $output_string = ob_get_contents();
          ob_end_clean();
        }
        return $output_string;

        //.. the Code is in the next steps ..//

      }

    } // End Element Class

    // Element Class Init
    new vcInfo();
