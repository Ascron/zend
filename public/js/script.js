$(function(){
    $.fn.showErr = function(msg){
        this.each(function(i, elem){
            var parent = $(elem).parent();
            if ($('ul.errors',parent).length==0){
                $("<ul class='errors'></ul>").appendTo(parent);
            }
            $('ul.errors',parent).append("<li>"+msg+"</li>")
        });

        return this;
    }
});