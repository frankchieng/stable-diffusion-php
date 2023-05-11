<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>stability图片改图片</title>
    <link rel="stylesheet" href="css/common.css?v1.1">
    <link rel="stylesheet" href="css/wenda.css?v1.1">
    <link rel="stylesheet" href="css/hightlight.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/dropzone.min.css">
      <style>
  #img2img-custom-handle {
    width: 3em;
    height: 1.6em;
    top: 50%;
    margin-top: -.8em;
    text-align: center;
    line-height: 1.6em;
  }
   #img2img-steps-custom-handle {
    width: 3em;
    height: 1.6em;
    top: 50%;
    margin-top: -.8em;
    text-align: center;
    line-height: 1.6em;
  } 
   #strength-custom-handle {
    width: 3em;
    height: 1.6em;
    top: 50%;
    margin-top: -.8em;
    text-align: center;
    line-height: 1.6em;
  } 

   #img2img-sample-custom-handle {
    width: 3em;
    height: 1.6em;
    top: 50%;
    margin-top: -.8em;
    text-align: center;
    line-height: 1.6em;
  } 
  </style>
</head>

<body>
    <div class="layout-wrap">
        <header class="layout-header">
            <div class="container" data-flex="main:justify cross:start">
                <div class="header-logo"> 
                    <h2 class="logo"><a class="links" id="pic-intro" title="生成图片说明"><span class="logo-title">图片生成尽量输入英文，中文识别率不太高</span></a></h2>
                </div>  

                <!--<div class="header-logo">
                    <h2 class="logo"><a class='links' id='donate' title='请点击付费'><span class='logo-title'>点击查看额度
                    </span></a></h2>
                </div>-->
            </div>
        </header>
        <div class="layout-content">

            <div class="container">

                <article class="article" id="article">
                    <div class="article-box">

                        <div class="precast-block" data-flex="main:left">
                            <div class="input-group">
                                <span style="text-align: center;color:#9ca2a8">&nbsp;&nbsp;目前文字生成图片等待时间比较长1分钟左右，等待途中不要关闭访问，生成图片后可以长按图片保存到本地，有任何问题可以联系添加管理员微信号：714580106 </span>
                            </div>
                        </div>

            <span style="color:#9ca2a8">上传图片:</span>
             
<div class="dropzone" id="myDropzone">
    <div class="am-text-success dz-message">
        点此打开文件管理器选择图片<br>只支持png后缀名图片
    </div>
</div>


     <span style="color:#9ca2a8">引擎选择：</span>
                                <select id="img2imgenginelist" style="width:calc(100% - 90px);max-width:180px;">
    <?php
    require_once('config.inc.php');
    foreach($SD_ENGINE_LIST as $engine) {
    ?>
        <option value="<?php echo $engine;?>"><?php echo $engine;?></option>
    <?php
    }
    ?>
    </select>

    <span style="color:#9ca2a8">采样器：</span>
    <select id="img2imgsamplerlist" style="width:calc(100% - 90px);max-width:180px;">
    <?php
    foreach($SD_SAMPLER as $sampler) {
    ?>
        <option value="<?php echo $sampler;?>"><?php echo $sampler;?></option>
    <?php
    }
    ?>
    </select>

     <span style="color:#9ca2a8;margin-bottom:5px;">图片增强值:(1更接近原图,0和原图差别最大):&nbsp;&nbsp;</span>
      <input type="hidden" id="image_strength">
     <div id="strengthslider" style="display:inline-block;width:calc(100% - 90px);max-width:180px;">
  <div id="strength-custom-handle" class="ui-slider-handle"></div>
</div>


     <span style="color:#9ca2a8;margin-top:5px;margin-bottom:5px;">Cfg Scale:(值越高，生成的图片越吻合你的描述)</span>
      <input type="hidden" id="img2imgcfgscale">
     <div id="img2imgslider" style="width:calc(100% - 90px);max-width:350px;margin-top:5px;margin-bottom:5px;">
  <div id="img2img-custom-handle" class="ui-slider-handle"></div>
</div>
     <span style="color:#9ca2a8;margin-top:5px;margin-bottom:5px;">Steps:(影响画面的完成度，值越高，越会在后面的步数中倾向于渲染细节,步数越高生成图片速度越慢，建议50以下)</span>
      <input type="hidden" id="img2imgsteps">
     <div id="img2imgstepslider" style="width:calc(100% - 90px);max-width:350px;margin-top:5px;margin-bottom:5px;">
  <div id="img2img-steps-custom-handle" class="ui-slider-handle"></div>
</div>

      <span style="color:#9ca2a8;margin-top:5px;margin-bottom:5px;">Seed:(种子值，0生成随机种子数):&nbsp;&nbsp;</span>
        <input id="img2imgspinner" name="value">

     <span style="color:#9ca2a8;margin-top:5px;margin-bottom:5px;">生成图片数量:</span>
      <input type="hidden" id="img2imgsamples">
     <div id="img2imgsampleslider" style="width:calc(100% - 90px);max-width:180px;margin-top:5px;margin-bottom:5px;">
  <div id="img2img-sample-custom-handle" class="ui-slider-handle"></div>
</div>
                        <ul id="article-wrapper">

                        </ul>
                        <div class="creating-loading" data-flex="main:center dir:top cross:center">
                            <div class="semi-circle-spin"></div>
                        </div>
                        <div id="fixed-block">
                            <div class="precast-block" id="kw-target-box" data-flex="main:left cross:center">
                                <div id="target-box" class="box">
                                    <textarea name="kw-target" placeholder="在此提问生成图片" id="img2img-target" autofocus rows=1></textarea>
                                </div>
                                <div class="right-btn layout-bar">
                                    <p class="btn ai-btn bright-btn" id="img2img-btn" data-flex="main:center cross:center"><i class="iconfont icon-wuguan"></i>发送</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.cookie.min.js"></script>
    <script src="js/layer.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.mousewheel.js"></script>
    <script src="js/chat.js"></script>
    <script src="js/highlight.min.js"></script>
    <script src="js/showdown.min.js"></script>
    <script src="js/dropzone.min.js"></script>
    <script>
  Dropzone.autoDiscover = false;
  $( function() {
    var handle = $( "#img2img-custom-handle" );
    $( "#img2imgslider" ).slider({
      range: "max",
      min: 0,
      max: 35,
      value: 7,
      create: function() {
        handle.text( $( this ).slider( "value") );
         $("#img2imgcfgscale").val($( this ).slider( "value"));
      },
      slide: function( event, ui ) {
        handle.text( ui.value );
        $("#img2imgcfgscale").val( ui.value );
      }
    });

    var stephandle = $( "#img2img-steps-custom-handle" );
    $( "#img2imgstepslider" ).slider({
      range: "max",
      min: 0,
      max: 150,
      value: 30,
      create: function() {
        stephandle.text( $( this ).slider( "value") );
         $("#img2imgsteps").val($( this ).slider( "value"));
      },
      slide: function( event, ui ) {
        stephandle.text( ui.value );
        $("#img2imgsteps").val( ui.value );
      }
    });

    var strengthhandle = $( "#strength-custom-handle" );
    $( "#strengthslider" ).slider({
      range: "max",
      min:0,
      max: 1,
      value: 0.35,
      step: 0.01,
      create: function() {
        strengthhandle.text( $( this ).slider( "value") );
         $("#image_strength").val($( this ).slider( "value"));
      },
      slide: function( event, ui ) {
        strengthhandle.text( ui.value );
        $("#image_strength").val( ui.value );
      }
    });

    var spinner = $( "#img2imgspinner" ).spinner({
      spin: function( event, ui ) {
        if ( ui.value > 4294967295 ) {
          $( this ).spinner( "value", 0 );
          return false;
        } else if ( ui.value < 0 ) {
          $( this ).spinner( "value", 0 );
          return false;
        }
      }
    });
     spinner.spinner( "value", 0 );

    var samplehandle = $( "#img2img-sample-custom-handle" );
    $( "#img2imgsampleslider" ).slider({
      range: "max",
      min: 1,
      max: 4,
      value: 1,
      create: function() {
        samplehandle.text( $( this ).slider( "value") );
         $("#img2imgsamples").val($( this ).slider( "value"));
      },
      slide: function( event, ui ) {
        samplehandle.text( ui.value );
        $("#img2imgsamples").val( ui.value );
      }
    });


    function isInteger(arg) {
        const precision = 12; // for example
        return Number.isInteger(Number(arg.toFixed(precision)));
    }

    var multiplesImageWidth = 64, multiplesImageHeight = 64;
    $("#myDropzone").dropzone({
        url: "generateimg2img.php",
        addRemoveLinks: true,
        method: 'post',
        maxFiles: 1,
        maxFilesize: 5,
        acceptedFiles: "image/png",
        init: function() {
            this.on("success", function(file, response) {
                //console.log(response);
            });
            this.on("removedfile", function(file) {
                console.log("File " + file.name + "removed");
            });
            this.on("thumbnail", function(file) {
                if (isInteger(file.width/multiplesImageWidth) && isInteger(file.height/multiplesImageHeight)) {
                    file.acceptDimensions();

                }
                else {
                    file.rejectDimensions();
                }
            });
        },
        accept: function(file, done) {
            file.acceptDimensions = done;
            file.rejectDimensions = function() { done("上传图片的高度或者宽度不是64的整数倍."); };
        }

    });

  } );
    </script>
</body>

</html>