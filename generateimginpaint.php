<?php
error_reporting(E_ALL^E_WARNING);
require_once('config.inc.php');
session_start();
if ($_POST['action'] == "generatePic") {
        //获取图片各个参数
    $prompt = $_POST['message'];
    $cfgscale = $_POST['cfg_scale'];
    $sd_steps = $_POST['sd_steps'];
    $sd_sampler = $_POST['sd_sampler'];
    $style_preset = $_POST['style_preset'];
    $sd_seed = $_POST['sd_seed'];
    $sd_samples = $_POST['sd_samples'];
    $img_url = $_POST['img_url'];
    $img = str_replace('data:image/png;base64,', '', $img_url);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = "pics/image_name.png";
    $success = file_put_contents($file, $data);
    function imageInpaint($image_inpaint_url, $stability_api_key, $message, $cfg_scale, $steps, $sampler, $stylepreset, $seed, $samples, $inpaintfile)
    {
        //使用curl发送请求
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $image_inpaint_url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        //设置本地代理服务器
        curl_setopt($ch,CURLOPT_PROXY,'127.0.0.1');
        curl_setopt($ch,CURLOPT_PROXYPORT,'2712');
        //停止验证证书和host
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                "Content-Type: multipart/form-data", 
                "Authorization: Bearer " . $stability_api_key, 
            )
        );


        $fp   = fopen($_SESSION['targetfile'], 'rb'); // 打开图片
        $content = fread($fp, filesize($_SESSION['targetfile']));//二进制数据
        $inpaintfp   = fopen($inpaintfile, 'rb'); // 打开图片
        $mask_image = fread($inpaintfp, filesize($inpaintfile));//二进制数据

        $data = array("text_prompts[0][text]"=>$message,
            "mask_source" => MASK_SOURCE,
            "init_image" => $content,
            "mask_image" => $mask_image,
            "cfg_scale"=>intval($cfg_scale), 
            "samples"=>intval($samples),
            "sampler" => $sampler,
            "style_preset" => $stylepreset,
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

imageInpaint(STABILITYAI_IMG_INPAINT_URL, STABILITYAI_APP_KEY, $prompt, $cfgscale, $sd_steps, $sd_sampler, $style_preset, $sd_seed, $sd_samples, $file);

session_unset();
session_write_close(); 
}

?>
