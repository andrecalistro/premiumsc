$(document).ready(function(){
    $(".example").sortable({
        onMousedown: function ($item, _super, event) {
            console.log('aqui');
        }
    });
});