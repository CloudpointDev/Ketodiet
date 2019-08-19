(function($){    
    $.MalinaAjaxSearch  =  function(options)
    {
       var defaults = {
            delay: 300,                //delay in ms until the user stops typing.
            minChars: 3,               //dont start searching before we got at least that much characters
            scope: 'body'

        }

        this.options = $.extend({}, defaults, options);
        this.scope   = $(this.options.scope);
        this.timer   = false;
        this.lastVal = "";

        this.bind_events();
    }
    $.MalinaAjaxSearch.prototype =
    {
        bind_events: function()
        {   
            this.scope.on('keyup', '#header-s' , $.proxy( this.try_search, this));
        },

        try_search: function(e)
        {
            clearTimeout(this.timer);

            //only execute search if chars are at least "minChars" and search differs from last one
            if(e.currentTarget.value.length >= this.options.minChars && this.lastVal != $.trim(e.currentTarget.value))
            {
                //wait at least "delay" miliseconds to execute ajax. if user types again during that time dont execute
                this.timer = setTimeout($.proxy( this.do_search, this, e), this.options.delay);
            }
        },
        destory_results: function(e){
            var results = $('#header #search-list');
            results.remove();
        },
        do_search: function(e)
        {
            var obj          = this,
                currentField = $(e.currentTarget).attr( "autocomplete", "off" ),
                form         = currentField.parents('form:eq(0)'),
                results      = form.parent().find('#search-list'),
                loading      = $('<div id="ajax_load"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>'),
                action       = form.attr('action'),
                values       = form.serialize();
                values      += '&action=malina_ajax_search';

            //check if the form got get parameters applied and also apply them
            if(action.indexOf('?') != -1)
            {
                action  = action.split('?');
                values += "&" + action[1];
            }

            if(e.currentTarget.value.length <= this.options.minChars){
                results.remove();
            }
            if(!$('#search-list').length){
                results = $('<div id="search-list"></div>').appendTo(form.parent());
            }

            //return if we already hit a no result and user is still typing
            if(results.find('.ajax_not_found').length && e.currentTarget.value.indexOf(this.lastVal) != -1) return;

            this.lastVal = e.currentTarget.value;

            $.ajax({
                url: malinaAjaxSearch.ajaxurl,
                type: "POST",
                data:values,
                beforeSend: function()
                {
                    if(!$('#ajax_load').length){
                        loading.appendTo(results);
                    }
                },
                success: function(response)
                {
                    if(response == 0) {
                        response = "";
                    }
                    results.html(response);
                },
                complete: function()
                {
                    loading.remove();
                }
            });
        }
    }
    $(document).ready(function(){
        new $.MalinaAjaxSearch({scope:'#header'});
        $(document).click(function() {
            $('#header #search-list').remove();
        });
    });
})(jQuery);