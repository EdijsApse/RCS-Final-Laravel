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
        $(this.element).animate({opacity: 1}, this.animationTime);
    }

    this.updateMessage = function(msg)
    {
        $(this.element).find('.ws-message-content').text(msg);
    }

    this.hide = function()
    {
        $(this.element).animate({opacity: 0}, this.animationTime);
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


$(document).ready(function(){
    var message = new WS.Message;
    message.init($('.ws-message'));

    var loadMore = new WS.LoadMore;
    loadMore.init($('.load-more'));

    var menuBackground = new WS.MenuBackground;
    menuBackground.init();

    var postLike = new WS.PostLikeAction;
    postLike.init($('.post-like-button'), $('.post-like-count'));


})
