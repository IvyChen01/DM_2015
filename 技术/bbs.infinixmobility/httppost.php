<?php
    // 存在flag
    if (isset($_POST['flag'])){
        if ($_POST['flag'] == 1){
            $url = "http://79.125.125.243:8280/getValidateCode";
            $post_data = array (
                "internationalCode=" . $_POST['internationalCode'],
                "tel=" . $_POST['tel'],
                "param=" . $_POST['param']
            );
        }else if($_POST['flag'] == 2) {
            $url = "http://79.125.125.243:8280/auditValidateCode";
            $post_data = array (
                "tel=" . $_POST['tel'],
                "vcode=" . $_POST['vcode']
            );
        }
        
        $post_data = implode('&',$post_data);
       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变�?
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($output);
        echo $obj->code;
    }
?>

