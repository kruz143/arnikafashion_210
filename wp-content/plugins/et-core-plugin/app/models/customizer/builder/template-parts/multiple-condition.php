<?php

/**
 * The template for displaying multiple each header condition of Wordpress customizer
 *
 * @since   1.4.5
 * @version 1.0.1
 * @log
 * 1.0.1
 * Added sub-items checkbox
 * Added languages select
 */

$Etheme_Customize_Builder = new Etheme_Customize_header_Builder();
$header     = false;
$header     = apply_filters( 'Etheme_Customize_Builder_ajax', $header );
// $conditions = $Etheme_Customize_Builder->get_json_option('et_multiple_conditions');

$builder = isset( $_POST['builder'] ) ? $_POST['builder'] : 'header';

if ( $builder == 'header' ) {
	$conditions = $Etheme_Customize_Builder->get_json_option('et_multiple_conditions');
} elseif( $builder == 'single-product' ){
	$conditions = $Etheme_Customize_Builder->get_json_option('et_multiple_single_product_conditions');
}

$header_conditions = array();

if ( $header ) {
	foreach ( $conditions as $key => $value ) {
		if ( $header === $value['header'] ) {
			$header_conditions[$key] = $value;
		}
	}
}

$languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
?>
<?php //if ( $header == 'et_add' ): ?>
<?php if ( ! count( $header_conditions ) ): ?>




	<?php if ( $builder == 'header' ): ?>
        <li class="et_condition" data-condition="">

            <?php if ($languages): ?>
                <select class="et-languages-select">
                    <?php
                        $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
                        foreach ( $languages as $language ) {
                            echo '<option value="'.$language['language_code'].'">'.$language['language_code'].'</option>';
                        }
                    ?>
                </select>
			<?php endif; ?>

            <select class="primary-select">
                <option value="site">Entire Site</option>
                <option value="archives">Archives</option>
                <option value="singular">Singular</option>
            </select>

            <select class="secondary-select secondary-singular hidden">
				<?php foreach ($Etheme_Customize_Builder->get_all_single() as $key => $value): ?>
					<?php if ( is_array( $value ) && isset( $value['options']) ): ?>
                        <optgroup label="<?php echo $value['label'] ?>">
							<?php foreach ($value['options'] as $k => $v): ?>
                                <option value='<?php echo esc_attr( json_encode( $v ) ); ?>'><?php echo esc_html( $v['title'] ); ?></option>
							<?php endforeach; ?>
                        </optgroup>
					<?php else: ?>
                        <option value='<?php echo $key; ?>'><?php echo esc_html( $value['title'] ); ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
            </select>

            <select class="secondary-select secondary-archives hidden">
				<?php foreach ($Etheme_Customize_Builder->get_all_archive() as $key => $value): ?>
					<?php if ( is_array( $value ) && isset( $value['options']) ): ?>
                        <optgroup label="<?php echo $value['label'] ?>">
							<?php foreach ($value['options'] as $k => $v): ?>
                                <option value='<?php echo esc_attr( json_encode( $v ) ); ?>'><?php echo esc_html( $v['title'] ); ?></option>
							<?php endforeach; ?>
                        </optgroup>
					<?php else: ?>
                        <option value='<?php echo $key; ?>'><?php echo esc_html( $value['title'] ); ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
            </select>

            <select class="third-select hidden"></select>

            <span class="sub-items-section hidden">
                <label for="sub-items">
                    <input type="checkbox" name="sub-items" value="on" class="sub-items">
                    Sub-Items
                </label>
            </span>

            <div class="et_conditions-actions">
                <span class="et_condition-action et_condition-remove" data-action="remove"></span>
            </div>
        </li>
	<?php elseif($builder == 'single-product'): ?>
        <li class="et_condition" data-condition="">
	        <?php if ($languages): ?>
                <select class="et-languages-select">
			        <?php
			        $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
			        foreach ( $languages as $language ) {
				        echo '<option value="'.$language['language_code'].'">'.$language['language_code'].'</option>';
			        }
			        ?>
                </select>
	        <?php endif; ?>
            <select class="primary-select">
				<?php foreach ($Etheme_Customize_Builder->get_all_single('product') as $key => $value): ?>
					<?php if ( is_array( $value ) && isset( $value['options']) ): ?>
						<?php foreach ($value['options'] as $k => $v): ?>
                            <option value='<?php echo esc_attr( json_encode( $v ) ); ?>'><?php echo esc_html( $v['title'] ); ?></option>
						<?php endforeach; ?>
					<?php else: ?>
                        <option value='<?php echo $key; ?>'><?php echo esc_html( $value['title'] ); ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
                <option value='{"post_type":"product","type":"all","slug":"in_product","title":"In product"}'>In product</option>
            </select>

            <select class="third-select hidden"></select>

            <span class="sub-items-section hidden">
                <label for="sub-items">
                    <input type="checkbox" name="sub-items" value="on" class="sub-items">
                    Sub-Items
                </label>
            </span>

            <div class="et_conditions-actions">
                <span class="et_condition-action et_condition-remove" data-action="remove"></span>
            </div>
        </li>
	<?php endif; ?>













<?php else: ?>
	<?php if ( $builder == 'header' ): ?>
		<?php foreach ($header_conditions as $key => $condition): ?>
			<?php $show = false; ?>
            <li class="et_condition" data-condition="<?php echo $key ?>">
	            <?php if ($languages): ?>
                    <select class="et-languages-select">
			            <?php
			            $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
			            foreach ( $languages as $language ) {
				            echo '<option value="'.$language['language_code'].'" '. selected( $condition['language'], $language['language_code'], false) .'>'.$language['language_code'].'</option>';
			            }
			            ?>
                    </select>
	            <?php endif; ?>
                <select name="et_contion-select-1" class="primary-select">
                    <option value="site" <?php selected( $condition['primary'], 'site' ); ?>>Entire Site</option>
                    <option value="archives" <?php selected( $condition['primary'], 'archives' ); ?>>Archives</option>
                    <option value="singular" <?php selected( $condition['primary'], 'singular' ); ?>>Singular</option>
                </select>

				<?php ob_start(); ?>
				<?php foreach ($Etheme_Customize_Builder->get_all_single() as $key => $value): ?>
					<?php if ( is_array( $value )  && isset( $value['options'] ) ): ?>
                        <optgroup label="<?php echo $value['label'] ?>">
							<?php foreach ($value['options'] as $k => $v): ?>
								<?php
								// if (! $show && implode( $condition['secondary'] ) == implode( $v ) ) {
								// 	$show = true;
								// }

								if (
									// isset( $condition['secondary']['post_type'] ) &&
									// isset( $condition['secondary']['type'] )  &&
									// isset( $v['post_type'] ) &&
									// isset( $v['type'] ) &&
									// $condition['secondary']['post_type'] == $v['post_type'] &&
									// $condition['secondary']['type'] == $v['type'] ||


								! $show && is_array($condition['secondary']) && implode( $condition['secondary'] ) == implode( $v )
								) {
									$show = true;
								}
								?>

                                <!-- <option value='<?php //echo esc_attr( json_encode( $v ) ); ?>' <?php //selected( implode($condition['secondary']), implode( $v ) ); ?>> -->
                                <option
                                        value='<?php echo esc_attr( json_encode( $v ) ); ?>'
									<?php //selected( json_encode($condition['secondary']), json_encode( $v ) ); ?>
									<?php
									if (
										// isset( $condition['secondary']['post_type'] ) &&
										// isset( $condition['secondary']['type'] )  &&
										// isset( $v['post_type'] ) &&
										// isset( $v['type'] ) &&
										// $condition['secondary']['post_type'] == $v['post_type'] &&
										// $condition['secondary']['type'] == $v['type'] ||
									selected( json_encode($condition['secondary']), json_encode( $v ), false )
									) {
										echo 'selected="selected"';
									}
									?>
                                >
									<?php echo esc_html( $v['title'] ); ?>
                                </option>
							<?php endforeach; ?>
                        </optgroup>
					<?php else: ?>
						<?php
						if ( $key != 'select' && ! $show && $condition['secondary'] == $key ) {
							$show = true;
						}
						?>

                        <option value='<?php echo $key; ?>' <?php selected( json_encode($condition['secondary']), $key ); ?>>
							<?php echo esc_html( $value['title'] ); ?>
                        </option>
					<?php endif; ?>
				<?php endforeach; ?>

				<?php $options = ob_get_clean(); ?>
                <select class="secondary-select secondary-singular <?php echo ( ! $show ) ? 'hidden' : ''; ?>">
					<?php echo $options; ?>
                </select>

				<?php $show = false; ?>

				<?php ob_start(); ?>
				<?php foreach ( $Etheme_Customize_Builder->get_all_archive() as $key => $value ): ?>
					<?php if ( is_array( $value ) && isset( $value['options'] ) ): ?>
                        <optgroup label="<?php echo $value['label'] ?>">
							<?php foreach ($value['options'] as $k => $v): ?>
								<?php
								if (! $show && is_array($condition['secondary']) && implode( $condition['secondary'] ) == implode( $v ) ) {
									$show = true;
								}
								?>
                                <option value='<?php echo esc_attr( json_encode( $v ) ); ?>' <?php selected( json_encode($condition['secondary']), json_encode( $v ) ); ?>>
									<?php echo esc_html( $v['title'] ); ?>
                                </option>
							<?php endforeach; ?>
                        </optgroup>
					<?php else: ?>
						<?php
						if ( $condition['secondary'] != 'select' && ! $show && $condition['secondary'] == $key ) {
							$show = true;
						}
						?>

                        <option value='<?php echo $key; ?>' <?php selected( json_encode($condition['secondary']), $key ); ?>>
							<?php echo esc_html( $value['title'] ); ?>
                        </option>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php $options = ob_get_clean(); ?>
                <select class="secondary-select secondary-archives <?php echo ( ! $show ) ? 'hidden' : ''; ?>">
					<?php echo $options; ?>
                </select>

				<?php
				$default_third = '';
				if ( $condition['third']&&$condition['secondary'] ) {
					$Etheme_Customize_Builder = new Etheme_Customize_header_Builder();

					$atts	 = array();
					$atts	['selected'] = $condition['third'];
					$atts	['data'] = $condition['secondary'];

					$selected = $Etheme_Customize_Builder->condition_select_data($atts	);
					$default_third = '<option value="' . $selected[0]['id'] . '" selected="selected">' . $selected[0]['text'] . '</option>';
				}

				$var_types = array('product_cat', 'product_tag', 'brand', 'category', 'post_tag', 'portfolio_category');

                $sub_items_class = (is_array($condition['secondary']) && in_array($condition['secondary']['slug'], $var_types)) ? 'active': 'hidden' ;

				?>

                <select class="third-select <?php echo ( ! $default_third ) ? 'hidden' : ''; ?>">
					<?php echo $default_third; ?>
                </select>

                <span class="sub-items-section <?php echo $sub_items_class; ?>">
                    <label for="sub-items">
                        <input type="checkbox" name="sub-items" value="on" class="sub-items" <?php echo ( isset($condition['sub-items']) && $condition['sub-items'] == 'true') ? 'checked' : '' ?>>
                        Sub-Items
                    </label>
                </span>

                <div class="et_conditions-actions">
                    <span class="et_condition-action et_condition-remove" data-action="remove"></span>
                </div>
            </li>
		<?php endforeach ?>
	<?php elseif($builder == 'single-product'): ?>

		<?php foreach ($header_conditions as $key => $condition): ?>


			<?php $show = false; ?>
            <li class="et_condition" data-condition="<?php echo $key ?>">
	            <?php if ($languages): ?>
                    <select class="et-languages-select">
			            <?php
			            $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
			            foreach ( $languages as $language ) {
				            echo '<option value="'.$language['language_code'].'" '. selected( $condition['language'], $language['language_code'], false) .'>'.$language['language_code'].'</option>';
			            }
			            ?>
                    </select>
	            <?php endif; ?>
                <select name="et_contion-select-1" class="primary-select">

					<?php foreach ($Etheme_Customize_Builder->get_all_single('product') as $key => $value): ?>
						<?php if ( is_array( $value ) && isset( $value['options']) ): ?>
							<?php foreach ($value['options'] as $k => $v): ?>

                                <option value='<?php echo esc_attr( json_encode( $v ) ); ?>' <?php selected( implode($condition['primary']), implode( $v ) ); ?>>
									<?php echo esc_html( $v['title'] ); ?>
                                </option>

							<?php endforeach; ?>
						<?php else: ?>
                            <option value='<?php echo $key; ?>' <?php selected( $condition['primary'], $key ); ?>><?php echo esc_html( $value['title'] ); ?></option>
						<?php endif; ?>
					<?php endforeach; ?>
                    <option value='{"post_type":"product","type":"all","slug":"in_product","title":"In product"}' <?php selected( implode($condition['primary']), implode( array(
						"post_type"=>"product",
						"type"=>"all",
						"slug"=>"in_product",
						"title"=>"In product"
					) ) ); ?>>In product</option>



                </select>


				<?php
				$default_third = '';
				if ( $condition['third']&&$condition['primary'] ) {
					$Etheme_Customize_Builder = new Etheme_Customize_header_Builder();

					$atts	 = array();
					$atts	['selected'] = $condition['third'];

					$atts['data']     = $condition['primary'];

					$selected = $Etheme_Customize_Builder->condition_select_data($atts	);
					$default_third = '<option value="' . $selected[0]['id'] . '" selected="selected">' . $selected[0]['text'] . '</option>';
				}
				$var_types = array('product_cat', 'product_tag', 'brand', 'category', 'post_tag', 'portfolio_category');
				$sub_items_class = (in_array($condition['primary']['slug'], $var_types)) ? 'active': 'hidden' ;

				?>


                <select class="third-select <?php echo ( ! $default_third ) ? 'hidden' : ''; ?>">
					<?php echo $default_third; ?>
                </select>

                <span class="sub-items-section <?php echo $sub_items_class; ?>">
                    <label for="sub-items">
                        <input type="checkbox" name="sub-items" value="on" class="sub-items" <?php echo ( isset($condition['sub-items']) && $condition['sub-items'] == 'true') ? 'checked' : '' ?>>
                        Sub-Items
                    </label>
                </span>
                <div class="et_conditions-actions">
                    <span class="et_condition-action et_condition-remove" data-action="remove"></span>
                </div>
            </li>
		<?php endforeach ?>


	<?php endif; ?>
<?php endif; ?>