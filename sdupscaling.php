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
                                <span style="text-align: center;color:#9ca2a8">&nbsp;&nbsp;生成图片最大像素4194304，即尺寸为2048x2048或4096x1024，默认高和宽扩大两倍数值，有任何问题可以联系添加管理员微信号：714580106 </span>
                            </div>
                        </div>

            <span style="color:#9ca2a8">上传图片:</span>
             
<div class="dropzone" id="upscalingDropzone">
    <div class="am-text-success dz-message">
        点此选择图片<br>只支持png后缀名图片,图片尺寸必须是64的倍数，否则无法识别
    </div>
</div>

                        <ul id="article-wrapper">

                        </ul>

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
  
    function isInteger(arg) {
        const precision = 12; // for example
        return Number.isInteger(Number(arg.toFixed(precision)));
    }

    var multiplesImageWidth = 64, multiplesImageHeight = 64;
    $("#upscalingDropzone").dropzone({
        url: "generateupscalingimg.php",
        addRemoveLinks: true,
        method: 'post',
        maxFiles: 1,
        maxFilesize: 5,
        acceptedFiles: "image/png",
        init: function() {
            this.on("success", function(file, response) {
                var loading = layer.msg("正在生成图片，请耐心等待", {
                    icon: 16,
                    shade: 0.4,
                    time: false //取消自动关闭
                });
                console.log(response);
                layer.close(loading);
                $("#article-wrapper").append('<li class="pic-content"><img src="'+response+'"/></li>');                  
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