<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script src="js/JqueryFileUploader/vendor/jquery.ui.widget.js"></script>
    <script src="js/JqueryFileUploader/jquery.iframe-transport.js"></script>
    <script src="js/JqueryFileUploader/jquery.fileupload.js"></script>
    <style>
        .clearer{ clear: both; }
        #drop_zone{ padding: 50px; border: 1px solid; width: 50px; height: 50px; }
        .upload_preview{ display: none; }
        .upload_preview img, .upload_preview .progress_container, .upload_preview .delete{ float: left; }
        .progress_container{ width: 250px; }
        .progress_shade{ width: 0%; height: 15px; background: green; }
    </style>
    
    
    <link rel="stylesheet" type="text/css" href="css/link.preview.css" />
    <script type="text/javascript" src="js/link.preview.js" ></script>
</head>
<body>

    <form method="post" enctype="multipart/form-data" id="form">
        
        <div class="linkPreview" style="margin: 0;">
            <div id="previewLoading"></div>
            <div style="float: left;">
                <textarea type="text" id="text" /> What's on your mind?</textarea>
                <div style="clear: both"></div>
            </div>
            <div id="preview">
                <div id="previewImages">
                    <div id="previewImage"><img src='img/LinkPreview/loader.gif' style='margin-left: 43%; margin-top: 39%;' ></img></div>
                    <input type="hidden" id="photoNumber" value="0" />
                </div>
                <div id="previewContent">
                    <div id="closePreview" title="Remove" ></div>
                    <div id="previewTitle"></div>
                    <div id="previewUrl"></div>
                    <div id="previewDescription"></div>
                    <div id="hiddenDescription"></div>
                    <div id="previewButtons" >
                        <div id='previewPreviousImg' class="buttonLeftDeactive" ></div><div id='previewNextImg' class="buttonRightDeactive"  ></div>  <div class="photoNumbers" ></div> <div class="chooseThumbnail">Choose a thumbnail</div>
                    </div>
                    <input type="checkbox" id="noThumb" class="noThumbCb" />
                    <div class="nT"  ><span id="noThumbDiv" >No thumbnail</span></div>
                </div>
                <div style="clear: both"></div>
            </div>
            <div style="clear: both"></div>
            <div id="postPreview">
                <input class="postPreviewButton" type="submit" value="Post" />
                <div style="clear: both"></div>
            </div>
            <div class="previewPostedList"></div>
        </div><br/><br/>
        
        
        <input type="file" multiple id="file_uploader" data-url="jquery_file_uploader" />
        <input type="submit" value="Save" />
        
        
        <div id="drop_zone">drop zone</div>
        <div id="upload_preview_container">
            <div class="upload_preview">
                <img />
                <div class="progress_container">
                    <div class="progress_shade"></div>
                </div>
                <!--<input type="button" class="delete" value="Delete" data-type="" data-url="" />-->
                <input type="hidden" name="names[]" class="name" />
                <input type="hidden" name="image_urls[]" class="image_url" />
                <div class="clearer"></div>
            </div>
        </div><br/><br/>
        
    </form>
    
</body>
</html>

<script type="text/javascript">
    
    $('.linkPreview').linkPreview();
    
    
    $('#file_uploader').fileupload({
        dropZone: $('#drop_zone'),
        add: function(e, data){
            $('.upload_preview').eq(0).clone().appendTo('#upload_preview_container');
            $('.upload_preview').last().css('display', 'block');
            data.submit();
        },
        progress: function(e, data){
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.upload_preview').last().find('.progress_shade').css('width', progress + '%');
        },
        dataType: 'json',
        done: function(e, data){
            $('.upload_preview').last().find('img').attr('src', data.result[0].thumbnail_url);
            $('.upload_preview').last().find('.delete').attr('data-type', data.result[0].delete_type);
            $('.upload_preview').last().find('.delete').attr('data-url', data.result[0].delete_url);
            $('.upload_preview').last().find('.name').attr('value', data.result[0].name);
            $('.upload_preview').last().find('.image_url').attr('value', data.result[0].url);
        }
    });
    
</script>