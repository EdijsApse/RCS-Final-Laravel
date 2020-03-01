WS = {};

WS.Message = function()
{
    this.init = function(MessageElement)
    {
        this.animationTime = 100;

        this.element = MessageElement;
        this.toggleVisibility()

        $(this.element).find('.close-message').on('click', function(){
            this.hide();
        }.bind(this))
    }

    this.toggleVisibility = function()
    {
        if ($(this.element).hasClass('ws-message-visible')) {
            this.show();
            this.autoHide();
        }
    }

    this.show = function()
    {
        $(this.element).fadeIn('fast').animate({opacity: 1}, this.animationTime);
    }

    this.updateMessage = function(msg)
    {
        $(this.element).find('.ws-message-content').text(msg);
    }

    this.hide = function()
    {
        $(this.element).fadeOut('fast').animate({opacity: 0}, this.animationTime);
    }

    this.autoHide = function()
    {
        setTimeout(function(){
            $(this.element).animate({opacity: 0}, this.animationTime)
        }.bind(this), 2000);
    }
}

WS.LoadMore = function()
{
    this.init = function(loadMoreButton)
    {
        this.button = loadMoreButton;
        this.postExample = null;
        this.postsToRetrive = 4;
        this.offset = 0;
        this.postsContainer = $(".all-posts");

        $(this.button).click(function(){
            this.postExample = $("#post-example");
            this.offset = $('.visible-posts').length;
            this.sendRequest();
        }.bind(this))

        this.sendRequest = function()//@todo loader
        {
            var limit = this.postsToRetrive;
            var offset = this.offset;
            $.ajax({
                method:'GET',
                url: "/posts",
                dataType: "json",
                data:{
                    limit,
                    offset
                },
                success: function(response){

                    if (response.success) {
                        response.data.forEach(element => {
                            var clone = $(this.postExample).clone();
                            $(clone).find('.example-image').attr('src', element.picture);
                            $(clone).find('.example-date').text(element.date);
                            $(clone).find('.example-fullname').attr('href', element.author_link).text(element.author_fullname);
                            $(clone).find('.exmple-title').text(element.title);
                            $(clone).find('.exmple-body').text(element.description);
                            $(clone).find('.example-read-more').attr('href', element.link);
                            $(clone).find('.example-like').text(element.likes);
                            $(clone).find('.example-comment').text(element.comments);
                            $(clone).find('.example-view').text(element.views);
                            $(clone).find('.post').addClass('visible-posts');
                            $(clone).removeClass('d-none');
                            $(this.postsContainer).append($(clone));
                        });

                        if (!response.isMore) {
                            this.initMessage('Ooops... Looks like these are the last posts!');
                            this.hideButton();
                        }

                    } else {
                        this.initMessage('Looks like something went wrong!');
                    }
                }.bind(this),
                error: function(error) {
                    this.initMessage('Ooops... Looks like some error occured! Try again later!');
                }.bind(this)
            });
        }

        this.initMessage = function(msg)
        {
            var message = new WS.Message;
                message.init($('.ws-message'));
                message.updateMessage(msg);
                message.show();
                message.autoHide();
        }

        this.hideButton = function()
        {
            $(this.button).fadeOut();
        }
    }
}

WS.MenuBackground = function()
{
    this.init = function()
    {
        if ($(window).scrollTop()) {
            this.addDarkMode();
        } else {
            this.addLightMode();
        }

        $(window).scroll(function(e) {
            if ($(window).scrollTop() > 50) {
                this.addDarkMode();
            } else {
                this.addLightMode();
            }
        }.bind(this))
    }

    this.addDarkMode = function()
    {
        $('.ws-navbar-container').addClass('bg-menu');
    }

    this.addLightMode = function()
    {
        $('.ws-navbar-container').removeClass('bg-menu');
    }
}

WS.PostLikeAction = function()
{
    this.init = function(likeButton, likeCount)
    {
        this.likeButton = likeButton;
        this.likeCount = likeCount;

        $(this.likeButton).on('click', this.sendLikeRequest.bind(this));
    }

    this.sendLikeRequest = function()
    {
        $.ajax({
            method:'POST',
            url: window.location.href+'/like',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(response){
                if (response.success) {
                    this.initMessage('One like added to post! Good Job! uthor will be proud!');
                    $(this.likeCount).text(response.newLikeCount);
                    $(this.likeButton).addClass('liked');
                } else {
                    this.initMessage('Looks like you cant add like to this post!');
                }
            }.bind(this),
            error: function(error) {
                if (error.status == 401) {
                    this.initMessage('Please signe in to be able to like posts!');
                } else {
                    this.initMessage('Technical issues! Please try again later!');
                }
            }.bind(this)
        });
    }

    this.initMessage = function(msg)
    {
        var message = new WS.Message;
            message.init($('.ws-message'));
            message.updateMessage(msg);
            message.show();
            message.autoHide();
    }
}

WS.Validator = function()
{
    this.init = function(form)
    {

        this.form = form;
        this.message = '';
        this.input = {};
        this.errors = [];

        $(this.form).find('input, textarea').each(function(index, element){
            $(element).on('keyup', function(){
                this.input.element = element;
                this.input.index = index;
                this.validateInput();
            }.bind(this));
        }.bind(this));

        $(this.form).on('submit', function(e){
            this.triggerInputChanges();
            this.errors.forEach(function(isError){
                if (isError) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                }
            })
        }.bind(this));
    }

    this.triggerInputChanges = function()
    {
        $(this.form).find('input, textarea').each(function(){
            $(this).trigger('keyup');
        });
    }

    this.validateInput = function()
    {
        let minLength = $(this.input.element).data('min-length');
        let email = $(this.input.element).data('email');
        let passwordConfirm = $(this.input.element).data('password-confirm');
        let value = $(this.input.element).val();
        if (minLength) {
            if (minLength > value.length) {
                this.message = `Atleast ${minLength} characters expected`;
                this.showMessage();

                this.errors[this.input.index] = true;
            } else {
                this.hideMessage();
                this.errors[this.input.index] = false;
            }
        }

        if (email) {
            if (!this.isEmail()) {
                this.message = 'Looks like email is not valid!';
                this.showMessage();
                this.errors[this.input.index] = true;
            } else {
                this.hideMessage();
                this.errors[this.input.index] = false;
            }
        }

        if (passwordConfirm) {
            if (!this.isPasswordCorrect()) {
                this.message = 'Looks like passwords doesnt match!';
                this.showMessage();
                this.errors[this.input.index] = true;
            } else {
                this.hideMessage();
                this.errors[this.input.index] = false;
            }
        }



    }

    this.isPasswordCorrect = function()
    {
        let originalPass = $('input[name="password"]').val();
        if (originalPass == $(this.input.element).val()) {
            return true;
        }
        return false;
    }

    this.showMessage = function()
    {
        $(this.input.element).siblings('.error-message').children('p').text(this.message);
        $(this.input.element).siblings('.hidden-error-message').removeClass('hidden-error-message');
    }

    this.hideMessage = function()
    {
        $(this.input.element).siblings('.error-message').addClass('hidden-error-message');
    }

    this.isEmail = function()
    {
        //edijsapse@gmail.com
        let splitedEmail = $(this.input.element).val().split('@');//['edijsapse', 'gmail.com']

        if (splitedEmail.length != 2) {
            return false
        }

        let afterSymbol = splitedEmail[1].split('.');//gmail.com
        let beforeSymbol = splitedEmail[0];//edijsapse

        if (!beforeSymbol.length) {
            return false;
        }

        if (afterSymbol.length != 2) {
            return false
        }

        let afterDot = afterSymbol[1]; //.com

        if (afterDot.length < 2) {
            return false;
        }

        return true;
    }
}

WS.ImageChange = function()
{
    this.init = function(element)
    {
        this.input = element;

        $(this.input).on('change', this.notifyUser.bind(this));
    }

    this.notifyUser = function()
    {
        console.log($(this.input))

        $(this.input).siblings('.image-select-description').text('Image selected!');
    }
}

WS.PageScroller = function()
{
    this.init = function(scrollButton)
    {
        this.scrollButton = scrollButton;
        this.scrollToBottom = true;
        this.screenHeight = $('html').height();

        if (window.scrollY > this.getChangePoint()) {

            this.scrollToBottom = false;
        }

        $(this.scrollButton).on('click', function(){
            this.scrollPage();
        }.bind(this));

        $(window).on('scroll', function(e){
            this.currentYPosition = e.currentTarget.scrollY;
            this.changeDirection();
        }.bind(this));
    }

    this.getChangePoint = function()
    {
        return (this.screenHeight - window.screen.availHeight) / 2;
    }

    this.scrollPage = function()
    {
        if (this.scrollToBottom) {
            $('html, body').animate({
                scrollTop: $('html').height()
             }, 2000);
        } else {
            $('html, body').animate({
                scrollTop: 0
             }, 2000);
        }
    }

    this.changeDirection = function()
    {

        if (this.getChangePoint() < this.currentYPosition) {
            this.scrollToBottom = false;
        } else {
            this.scrollToBottom = true;
        }
        this.toggleButtons();
    }

    this.toggleButtons = function()
    {
        if (this.scrollToBottom) {
            $('.fa-chevron-down').removeClass('rotated');
        } else {
            $('.fa-chevron-down').addClass('rotated');
        }
    }
}

WS.RadioInput = function()
{
    this.init = function(input)
    {
        this.hiddenInput = input;

        this.input = $(this.hiddenInput).siblings('.ws-radio-container');

        this.inputGroup = $('input[name="'+$(this.hiddenInput).attr('name')+'"]');

        this.isChecked();

        $(this.hiddenInput).siblings();

        $(this.input).on('click', this.setChecked.bind(this));
    }

    this.setChecked = function()
    {
        $(this.inputGroup).removeAttr('checked');
        $(this.inputGroup).siblings('.ws-radio-container').removeClass('is-checked');

        $(this.input).addClass('is-checked');
        $(this.hiddenInput).attr('checked', true);

    }

    this.isChecked = function()
    {
        if ($(this.hiddenInput).is(":checked")) {
            $(this.input).addClass('is-checked');
        }
    }
}

WS.AjaxForm = function()
{
    this.init = function(form)
    {
        this.form = form;

        $(this.form).on('submit', function(e){
            e.preventDefault();
            this.submitForm();
        }.bind(this));
    }

    this.submitForm = function()
    {
        var data = $(this.form).serialize();
        $.ajax({
            method:'POST',
            url: "",
            dataType: "json",
            data,
            success: function(response){
                if (response.success) {
                    this.initMessage('Good job! Improvement created');
                } else {
                    this.initMessage(response.error);
                }
            }.bind(this),
            error: function(error) {
                this.initMessage('Looks like error occured! Please contact support team!');
            }.bind(this)
        });
    }

    this.initMessage = function(msg)
    {
        var message = new WS.Message;
        message.init($('.ws-message'));
        message.updateMessage(msg);
        message.show();
        message.autoHide();
    }
}

$(document).ready(function(){
    var message = new WS.Message;
    message.init($('.ws-message'));

    var loadMore = new WS.LoadMore;
    loadMore.init($('.load-more'));

    var menuBackground = new WS.MenuBackground;
    menuBackground.init();

    var postLike = new WS.PostLikeAction;
    postLike.init($('.post-like-button'), $('.post-like-count'));

    $('form').each(function(){
        var validator =  new WS.Validator();
        validator.init($(this));
    })

    $('input[type="file"]').each(function(){
        var imageChange = new WS.ImageChange;
        imageChange.init($(this));
    })

    var pageScroller = new WS.PageScroller;
    pageScroller.init($('.scroll-button'));

    $('input[type="radio"]').each(function(){
        var radioInput = new WS.RadioInput().init($(this));
    })

    $('form[data-ajax-form]').each(function(){
        new WS.AjaxForm().init($(this));
    })

})
