<?php
    global $bk_option;
    $bk_footer_type = '';
    if (isset ($bk_option['bk-footer-instagram']) && ($bk_option['bk-footer-instagram'] == 1)) {
        $bk_footer_type = '2';
    }else {
        $bk_footer_type = '1';
    }
    if ($bk_footer_type == '1') {
        get_template_part( 'library/templates/footers/footer1' );
    } else {
        get_template_part( 'library/templates/footers/footer2' );
    }