function onYouTubeIframeAPIReady() {
    new YT.Player('kmrc-video', {
        videoId: 'E20Tt5LXK8I',
        playerVars: {
            autoplay: 1,
            mute: 1,
            controls: 0,
            playsinline: 1,
            rel: 0
        },
        events: {
            onReady: function(event) {
                event.target.playVideo();
            }
        }
    });
}