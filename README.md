# stable-diffusion-php

stable diffusion text2img ,img2img,imginpaint and image upscaling of AI with php 

stability.ai API text to image, image to image, image mask inpainting with canvas and image upscaling with php coding

you can experience with the latest stable diffusion SDXL beta engine here.

you should define your own stability.ai api key in the config.inc.php file.If you see openAI configuration,just ignore it,i've implemented chatgpt and openai whisper audio to text already,but this project is just for image content.

because the stability.ai API documents has no clue of php version, develop from scratch FYI.If it's available for you, give me a star for supporting.

php+mysql+jquery
supported by php version >= 7.4.33

stabilityai.php is the text to image landing page.
sdimg2img.php is the image to image landing page. (upload img should be multiply of 64, otherwise the REST server will response with error)
sdupscaling.php is the image upscaling landing page.
sdimginpaint.php is the image mask inpaint landing page.

chrome browser and mobile phone visit with various jquery plugins.

tips:the whole project contains chatgpt and stable diffusion,so js/chat.js includes some chatgpt javascript,you should ignore it, backend administration contains chatgpt tokens consumption and fees codes and wechat userinfo,wepay integrated in this whole project,anyone want to follow leave a message here

plan for future:
complete various image generation AI functionalities ,cuz stability.ai currently has no controlnet API for use, continue to follow the latest info on official website.

text to image generating examples:
![image](https://github.com/frankchieng/stable-diffusion-php/blob/main/assets/%E5%BE%AE%E4%BF%A1%E5%9B%BE%E7%89%87_20230511202653.jpg)
![image](https://github.com/frankchieng/stable-diffusion-php/blob/main/assets/%E5%BE%AE%E4%BF%A1%E5%9B%BE%E7%89%87_20230511232607.jpg)
![image](https://github.com/frankchieng/stable-diffusion-php/blob/main/assets/%E5%BE%AE%E4%BF%A1%E5%9B%BE%E7%89%87_20230511232614.jpg)
![image](https://github.com/frankchieng/stable-diffusion-php/blob/main/assets/%E5%BE%AE%E4%BF%A1%E5%9B%BE%E7%89%87_20230511232621.jpg)

image to image generating examples:

original pic:

![image](https://github.com/frankchieng/stable-diffusion-php/blob/main/assets/ofo1Z5p46CxExkkA7HdQAyUBpOfg_20230512000111_4280277550.png)

prompt: a bedroom,a laptop on desk

![image](https://github.com/frankchieng/stable-diffusion-php/blob/main/assets/ofo1Z5p46CxExkkA7HdQAyUBpOfg_20230512000746_1057778417.png)
![image](https://github.com/frankchieng/stable-diffusion-php/blob/main/assets/ofo1Z5p46CxExkkA7HdQAyUBpOfg_20230512000746_4223862173.png)

image upscaling examples:
resolution 512*512

![image](https://github.com/frankchieng/stable-diffusion-php/blob/main/assets/512resolution.png)

resolution 1024*1024

![image](https://github.com/frankchieng/stable-diffusion-php/blob/main/assets/1024resolution.png)

resolution 2048*2048

![image](https://github.com/frankchieng/stable-diffusion-php/blob/main/assets/2048resolution.png)

image mask inpaint generation examples:

original pic:

![image](https://github.com/frankchieng/stable-diffusion-php/blob/main/assets/mmexport1685060511391.png)

canvas mask img:

![image](https://github.com/frankchieng/stable-diffusion-php/blob/main/assets/ofo1Z5oCLVFQDBsHJKVm5j_OlAF8_20230526102607_imageinpaint.png)

prompt:batman face

mask inpaint image:

![image](https://github.com/frankchieng/stable-diffusion-php/blob/main/assets/ofo1Z5oCLVFQDBsHJKVm5j_OlAF8_20230526102617_772632365.png)

![image](https://github.com/frankchieng/stable-diffusion-php/blob/main/assets/ofo1Z5oCLVFQDBsHJKVm5j_OlAF8_20230526102617_3555459258.png)

if anyone interested can contact me on my individual Weixin：

![image](https://github.com/frankchieng/imagegeneration/blob/main/wechat.jpg)
