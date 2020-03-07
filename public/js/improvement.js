if (typeof WS === "undefined") {WS = {}}

WS.Improvement = function()
{
    this.activeImprovement = '';
    this.targetStage = '';

    this.init = function()
    {

        $('.improvement-section').each(function(index, element){
            this.initDropPlaceEvents(element);
        }.bind(this));

        $('.improvement').each(function(index, element){
            this.initDragElementEvents(element);
        }.bind(this));
    }

    /**
     * Setting all needed events for stage element
    */
    this.initDropPlaceEvents = function(element)
    {
        $(element).on('dragover', function(e){
            e.preventDefault();
            this.targetStage = $(e.currentTarget);
            this.addShadow();
        }.bind(this));

        $(element).on('dragleave',function(){
            this.removeShadow();
        }.bind(this));

        $(element).on('drop',function(e){
            e.preventDefault();
            this.removeShadow();
            this.addItem();
        }.bind(this));
    }

    /**
     * Setting all needed events for improvement element
    */
    this.initDragElementEvents = function(element)
    {
        $(element).on('dragstart', function(e){
            this.activeImprovement = $(e.currentTarget);
        }.bind(this));
    }

    /**
     * Sending AJAX to change improvement status!
     */
    this.addItem = function()
    {
        let status = $(this.targetStage).data('status');
        let improvement = $(this.activeImprovement).data('id');
        $.ajax({
            method:'POST',
            dataType: "json",
            url:"improvement/change-status",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                status,improvement
            },
            success: function(response){
                if (response.success) {
                    this.initMessage('Improvement status updated!');
                    this.changeStatus();
                } else {
                    this.initMessage(response.error);
                }
            }.bind(this),
            error: function(error) {
                this.initMessage('Looks like error occured! Please contact support team!');
            }.bind(this)
        });
    }

    /**
     * Appending improvement to new stage
     */
    this.changeStatus = function()
    {
        if ($(this.targetStage).find('.improvement').length) {
            $(this.activeImprovement).insertBefore($(this.targetStage).children('.improvement').first());
        } else {
            $(this.activeImprovement).appendTo($(this.targetStage));
        }
    }

    this.initMessage = function(msg)
    {
        var message = new WS.Message;
        message.init($('.ws-message'));
        message.updateMessage(msg);
        message.show();
        message.autoHide();
    }

    /**
     * Checks if draged item is in the same section, if not, add class
     */
    this.addShadow = function()
    {
        if (this.canBeAddedToStage()) {
            $(this.targetStage).addClass('box-shadow-container');
        }
    }

    //Check if improvement can be added to this stage
    this.canBeAddedToStage = function()
    {   console.log($(this.activeImprovement).parent().data('status'));
        return $(this.activeImprovement).parent().data('status') != $(this.targetStage).data('status') ? true : false;
    }

    /**
     * Remove shadows
     */
    this.removeShadow = function()
    {
        $(this.targetStage).removeClass('box-shadow-container');
    }
}

$(document).ready(function(){
    new WS.Improvement().init();
})
