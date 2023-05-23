<?php
error_reporting(E_ALL^E_WARNING);
require_once('config.inc.php');
session_start();
if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    $targetFile = $_FILES['file']['name'];
    move_uploaded_file($tempFile, __DIR__.'/pics/imgupscaling/'.$targetFile);
    //使用curl发送请求
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, STABILITYAI_IMG_UPSCALE_URL);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    //设置本地代理服务器
    //curl_setopt($ch,CURLOPT_PROXY,'127.0.0.1');
    //curl_setopt($ch,CURLOPT_PROXYPORT,'2712');
    //停止验证证书和host
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            "Content-Type: multipart/form-data", 
            "Authorization: Bearer ".STABILITYAI_APP_KEY, 
            )
        );
    $fp   = fopen(__DIR__.'/pics/imgupscaling/'.$targetFile, 'rb'); // 打开图片
    $content = fread($fp, filesize(__DIR__.'/pics/imgupscaling/'.$targetFile));//二进制数据
    $data = array("image" => $content);
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    $response=curl_exec($ch);
    curl_close($ch);
    $response_data=json_decode($response,true);

    //获取生成图片
    $imageName = date("YmdHis",time())."_".rand(1,99999)."_".$response_data['artifacts'][0]['seed'].'.png';
        $path = 'pics/imgupscaling';
        $imageSrc= $path."/". $imageName;
        $image = $response_data['artifacts'][0]['base64'];
        $image = base64_decode($image);
        $r = file_put_contents($imageSrc, $image);
        $image = imagecreatefrompng($imageSrc);
    echo $imageSrc;
}

?>