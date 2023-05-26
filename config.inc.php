<?php
//stability api秘钥
define('STABILITYAI_APP_KEY','');//use your own api key
define('STABILITYAI_BASE_URL','https://api.stability.ai');
define('STABILITYAI_ENGINE_LIST_URL', STABILITYAI_BASE_URL.'/v1/engines/list');
define('DEFAULT_STABILITY_ENGINE','stable-diffusion-512-v2-1');
$SD_SAMPLER = array('DDIM', 'DDPM', 'K_DPMPP_2M','K_DPMPP_2S_ANCESTRAL', 'K_DPM_2', 'K_DPM_2_ANCESTRAL', 'K_EULER', 'K_EULER_ANCESTRAL', 'K_HEUN','K_LMS');
define('INIT_IMAGE_MODE','IMAGE_STRENGTH');
$SD_ENGINE_LIST = array('stable-diffusion-v1-5', 'stable-diffusion-512-v2-0', 'stable-diffusion-768-v2-0', 'stable-diffusion-depth-v2-0', 'stable-diffusion-512-v2-1', 'stable-diffusion-768-v2-1', 'stable-diffusion-xl-beta-v2-2-2');
define('OPENAI_AUDIO_URL','https://api.openai.com/v1/audio/transcriptions');
define('OPENAI_API_KEY','');//use your own api key
define('OPENAI_AUDIO_MODEL', 'whisper-1');
$SD_STYLE_PRESET = array('3d-model', 'analog-film', 'anime', 'cinematic', 'comic-book', 'digital-art', 'enhance', 'fantasy-art', 'isometric', 'line-art', 'low-poly', 'modeling-compound', 'neon-punk', 'origami', 'photographic', 'pixel-art', 'tile-texture');
define('STABILITYAI_IMG_UPSCALE_URL', STABILITYAI_BASE_URL.'/v1/generation/esrgan-v1-x2plus/image-to-image/upscale');
define('STABILITYAI_IMG_INPAINT_URL', STABILITYAI_BASE_URL.'/v1/generation/stable-inpainting-512-v2-0/image-to-image/masking');
define('MASK_SOURCE', 'MASK_IMAGE_WHITE');
?>
