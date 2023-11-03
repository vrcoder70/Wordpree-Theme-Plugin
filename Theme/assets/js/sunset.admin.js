jQuery(document).ready( function($){

    var mediaUploader;
	
	$('#upload-button').on('click',function(e) {
		e.preventDefault();
		if( mediaUploader ){
			mediaUploader.open();
			return;
		}
		
		mediaUploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose a Profile Picture',
			button: {
				text: 'Choose Picture'
			},
			multiple: false
		});
		
		mediaUploader.on('select', function(){
			attachment = mediaUploader.state().get('selection').first().toJSON();
			$('#profile-picture').val(attachment.url);
            $('#profile-picture-preview').css('background-image','url(' + attachment.url + ')');
		});
		
		mediaUploader.open();
		
	});

    $('#remove-button').on('click', function(e){
        e.preventDefault();
        var answer = confirm("Are you sure you want to Remove Profile Picture?");
        if ( answer == true ) {
            //console.log("yes");
            $('#profile-picture').val('');
            $('.sunset-general-form').submit();
            $('.image-container').css('display','none');
        } else {
            //console.log("No");
        }
        return;
    });

});