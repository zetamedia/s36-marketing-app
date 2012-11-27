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
</head>
<body>

    <form method="post" enctype="multipart/form-data" id="form">
        <!--<input type="text" id="url" placeholder="url" size="100" value="http://mashable.com/2012/01/25/get-old-facebook-back" />-->
        <input type="text" id="url" placeholder="url" size="100" value="" />
        <input type="button" value="test" id="test" /><br/><br/>
        
        
        <input type="file" multiple id="file_uploader" data-url="jqueryfileuploader" />
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
        
        
        <div id="url_preview">
            <img src="" />
        </div>
    </form>
    
</body>
</html>

<script type="text/javascript">
    
    $('#test').click(function(e){
        
        e.preventDefault();
        
        var url = $('#url').val();
        var query = 'http://query.yahooapis.com/v1/public/yql?q=' + encodeURIComponent('SELECT * FROM html WHERE url="' + url + '" AND xpath="//title|//head/meta"') + '&format=json&diagnostics=true&callback=?';
        
        $.ajax({
            type: 'GET',
            dataType: 'jsonp',
            url: query,
            success: function(data){
                
                var title = 'title => ' + data.query.results.title;
                var url = 'url => ' + data.query.diagnostics.url.content;
                var desc = 'desc => ';
                var img = '';
                var misc = '';
                
                $.each(data.query.results.meta, function(k, v){
                    
                    if( v.name == 'description' ){
                        desc += v.content;
                    }
                    
                    //misc += k + ' => ' + v.name + '<br/>';
                    //misc += k + ' => ' + v.content + '<br/>';
                    $.each(v, function(a, b){
                        misc += a + ' => ' + b + '<br/>';
                    });
                    
                });
                
                $('#url_preview').html( title + '<br/>' + desc + '<br/>' + url + '<br/><br/>' + misc );
                //$('#url_preview img').attr('src', img);
            }
        });
        
    });
    
    
    
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