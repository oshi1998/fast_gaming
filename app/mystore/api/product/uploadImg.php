<?php

if (isset($_FILES['upload']['name'])) {
    $extension = strrchr($_FILES['upload']['name'], '.');
    $file = uniqid() . $extension;
    $filetmp = $_FILES['upload']['tmp_name'];

    $save_target = '../../../images/products/ckeditor/' . $file;
    move_uploaded_file($filetmp, $save_target);
    $function_number = $_GET['CKEditorFuncNum'];
    $url = "http://localhost/fast_gaming/app/images/products/ckeditor/" . $file;
    $message = '';

    echo "<script>
        window.parent.CKEDITOR.tools.callFunction('$function_number','$url','$message')
    </script>";
}
