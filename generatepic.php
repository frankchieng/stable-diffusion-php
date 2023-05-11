<?php
require_once('config.inc.php');
if ($_POST['action'] == "generatePic") {
error_reporting(E_ALL^E_WARNING);
//获取图片各个参数
$prompt = $_POST['message'];
$cfgscale = $_POST['cfg_scale'];
$sd_steps = $_POST['sd_steps'];
$stabilityai_engine = $_POST['stabilityai_engine'];
$sd_height = $_POST['sd_height'];
$sd_width = $_POST['sd_width'];
$sd_sampler = $_POST['sd_sampler'];
$sd_seed = $_POST['sd_seed'];
$sd_samples = $_POST['sd_samples'];
//stability api秘钥
$api_key = '';//use your own api key
$base_url = 'https://api.stability.ai';
$user_account_url = $base_url.'/v1/user/account';
$user_balance_url = $base_url.'/v1/user/balance';
$engine_list_url = $base_url.'/v1/engines/list';
//$prompt_image_url = $base_url.'/v1/generation/stable-diffusion-768-v2-1/text-to-image';
$prompt_image_url = STABILITYAI_BASE_URL.'/v1/generation/'.$stabilityai_engine.'/text-to-image';

//文字生成图片
function promptToImage($api_prompt_image_url, $stability_api_key, $message, $cfg_scale, $steps, $height, $width, $sampler, $seed, $samples)
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
            "Content-Type: application/json", 
            //"Accept: image/png",
            "Authorization: Bearer " . $stability_api_key, 
        )
    );
    //设置请求的参数
    $data = array("text_prompts"=>array(["text"=>$message]),
        "cfg_scale"=>intval($cfg_scale), 
        "height"=>intval($height), 
        "width"=>intval($width), 
        "samples"=>intval($samples),
        "sampler" => $sampler,
        "seed" => intval($seed),
        "steps"=>intval($steps)); 
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
    $response=curl_exec($ch);
    curl_close($ch);
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
            $imageName = date("YmdHis",time())."_".$response['seed'].'.png';
            $path = 'pics';
            $imageSrc= $path."/". $imageName;
            $image = $response['base64'];
            $image = base64_decode($image);
            $r = file_put_contents($imageSrc, $image);
            $image = imagecreatefrompng($path. "/".$imageName);
            $sd_pics[] = array('image_path'=>$imageSrc, 'seed'=>$response['seed']);
        }
        echo json_encode($sd_pics);
    }
}

promptToImage($prompt_image_url, $api_key, $prompt, $cfgscale, $sd_steps, $sd_height, $sd_width, $sd_sampler, $sd_seed, $sd_samples);
}
?>
