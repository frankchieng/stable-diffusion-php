<?php
error_reporting(E_ALL^E_WARNING);
require_once('config.inc.php');
session_start();
if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    //$_SESSION['tempfile'] = $tempFile;
    $targetFile = $_FILES['file']['name'];
    $_SESSION['targetfile'] = __DIR__.'/pics/'.$targetFile;
    //echo $_SESSION['tempfile']."<br>".$targetFile;
    move_uploaded_file($tempFile, __DIR__.'/pics/'.$targetFile);
}

if ($_POST['action'] == "generatePic") {
    //获取图片各个参数
    $prompt = $_POST['message'];
    $cfgscale = $_POST['cfg_scale'];
    $sd_steps = $_POST['sd_steps'];
    $stabilityai_engine = $_POST['stabilityai_engine'];
    $sd_sampler = $_POST['sd_sampler'];
    $sd_seed = $_POST['sd_seed'];
    $sd_samples = $_POST['sd_samples'];
    $image_strength = $_POST['image_strength'];
    $prompt_image_url = STABILITYAI_BASE_URL.'/v1/generation/'.$stabilityai_engine.'/image-to-image';

    //echo $_SESSION['tempfile'].$prompt.$cfgscale.$sd_steps.$stabilityai_engine.$sd_sampler.$sd_seed.$sd_samples.$image_strength.$prompt_image_url;
        //文字生成图片
    function promptToImage($api_prompt_image_url, $stability_api_key, $message, $cfg_scale, $steps, $sampler, $seed, $samples, $imagestrength)
    {
        //使用curl发送请求
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_prompt_image_url);
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
                //"Accept: application/json",
                //"Accept: image/png", 
                "Authorization: Bearer " . $stability_api_key, 
            )
        );


        $fp   = fopen($_SESSION['targetfile'], 'rb'); // 打开图片
        $content = fread($fp, filesize($_SESSION['targetfile']));//二进制数据

        $data = array("text_prompts[0][text]"=>$message,
            "init_image" => $content,
            "cfg_scale"=>intval($cfg_scale), 
            "init_image_mode"=>INIT_IMAGE_MODE,
            "image_strength" =>floatval($imagestrength),
            "samples"=>intval($samples),
            "sampler" => $sampler,
            "seed" => intval($seed),
            "steps"=>intval($steps)); 
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        $response=curl_exec($ch);
        curl_close($ch);
        //echo $response;

        //处理反馈
        $response_data=json_decode($response,true);
        if ($response_data['name']=='unauthorized') {
            echo "未授权，验证错误，请重试!";
        } elseif ($response_data['name']=='server_error') {
            echo "未预料到的服务器错误，请重试!";
        } elseif ($response_data['name']=='permission_denied') {
            echo "您不被允许访问此资源!";
        } elseif ($response_data['name']=='not found') {
            echo "指定的引擎未找到!";
        } else {
            //获取生成图片
            $sd_pics = array();
            foreach ($response_data['artifacts'] as $key=>$response) {
                $imageName = date("YmdHis",time())."_".rand(1,99999)."_".$response['seed'].'.png';
                $path = 'pics';
                $imageSrc= $path."/". $imageName;
                $image = $response['base64'];
                $image = base64_decode($image);
                $r = file_put_contents($imageSrc, $image);
                $image = imagecreatefrompng($imageSrc);
                $sd_pics[] = array('image_path'=>$imageSrc, 'seed'=>$response['seed']);
            }
            echo json_encode($sd_pics);
        }

    }

promptToImage($prompt_image_url, STABILITYAI_APP_KEY, $prompt, $cfgscale, $sd_steps, $sd_sampler, $sd_seed, $sd_samples, $image_strength);

session_unset();
session_write_close(); 

}


?>
