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
        .displayed_name{ display: none; }
        .upload_preview img, 
        .upload_preview .progress_container, 
        .upload_preview .delete,
        .upload_preview .displayed_name{ float: left; }
        .progress_container{ width: 100px; }
        .progress_shade{ width: 0%; height: 15px; background: url(progressbar.gif) green; }
    </style>
    
    
    <link rel="stylesheet" type="text/css" href="css/link.preview.css" />
    <script type="text/javascript" src="js/link.preview.min.js" ></script>
</head>
<body>
    <?php Session::put('feedback_sess', Str::random(32));  // to be used as upload sub dir. ?>
    <form method="post" enctype="multipart/form-data" id="form">
        
        <div class="linkPreview" style="margin: 0;">
            <div id="previewLoading"></div>
            <textarea type="text" id="text" ></textarea>
            <div id="link_preview_data"></div>
        </div>
        
        
        <br/><br/>
        <input type="file" multiple id="file_uploader" data-url="jquery_file_uploader" />
        <input type="submit" value="Save" />
        
        
        <div id="drop_zone">drop zone</div>
        <div id="upload_preview_container">
            <div class="upload_preview">
                <div class="progress_container">
                    <div class="progress_shade"></div>
                </div>
                <img />
                <div class="displayed_name"></div>
                <input type="button" class="delete" value=" X " />
                <input type="hidden" name="image_names[]" class="image_name" />
                <input type="hidden" name="image_urls[]" class="image_url" />
                <div class="clearer"></div>
            </div>
        </div><br/><br/>
        
    </form>
    
</body>
</html>

<script type="text/javascript">
    
    $('#text').linkPreview();
    
    
    $('#file_uploader').fileupload({
        dropZone: $('#drop_zone'),
        dataType: 'json',
        add: function(e, data){
            
            // accept image files only.
            var image_types = ['image/gif', 'image/jpg', 'image/jpeg', 'image/png'];
            if( image_types.indexOf( data.files[0].type ) == -1 ){
                alert('Please select an image file');
                return false;
            }
            
            // limit image size to 2mb.
            if( data.files[0].size > 2000000 ){
                alert('Please upload an image that is less than 2mb');
                return false;
            }
            
            // limit image upload to 3.
            if( $('.displayed_name').length >= 4 ){
                alert('You can only upload up to 3 images');
                return false;
            }
            
            $('.upload_preview').eq(0).clone().appendTo('#upload_preview_container');
            $('.upload_preview').last().css('display', 'block');
            data.submit();
            
            // disable file uploader if uploaded images are already 3.
            if( $('.displayed_name').length >= 4 ){
                $('#file_uploader').attr('disabled', 'disabled');
            }
            
        },
        progress: function(e, data){
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.upload_preview').last().find('.progress_shade').css('width', progress + '%');
        },
        done: function(e, data){
            $('.upload_preview').last().find('.displayed_name').text(data.result[0].name);
            $('.upload_preview').last().find('.displayed_name').css('display', 'inline-block');
            
            $('.upload_preview').last().find('.image_name').attr('value', data.result[0].name);
            $('.upload_preview').last().find('.image_url').attr('value', data.result[0].url);
            $('.upload_preview').last().find('.progress_container').css('display', 'none');
            $('.upload_preview').last().find('img').attr('src', data.result[0].thumbnail_url);
            //$('.upload_preview').last().find('.delete').attr('data-type', data.result[0].delete_type);
            //$('.upload_preview').last().find('.delete').attr('data-url', data.result[0].delete_url);
            //$('.upload_preview').last().find('.delete').bind('click', delete_image);
            $('.upload_preview').last().find('.delete').bind('click', function(){
                $.post( data.result[0].delete_url );
                $('#file_uploader').removeAttr('disabled');
                $(this).parents('.upload_preview').remove();
            });
        }
    });
    
</script>