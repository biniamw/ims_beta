$("#ItemImage").fileinput(
{
    overwriteInitial: true,
	maxFileSize: 2500,
	showClose: false,
	showCaption: false,
	browseLabel: '',
	removeLabel: '',
	browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
	removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
	removeTitle: 'Cancel or reset changes',
	elErrorContainer: '#kv-avatar-errors-1',
	msgErrorClass: 'alert alert-block alert-danger',
	defaultPreviewContent: '<img src="assests/images/photo_default.png" alt="Profile Image" style="width:100%;">',
	layoutTemplates: {main2: '{preview} {remove} {browse}'},								    
	allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
});