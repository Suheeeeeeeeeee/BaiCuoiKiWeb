document.addEventListener('DOMContentLoaded', function () {
    var addToPlaylistButtons = document.querySelectorAll('.addToPlaylistButton');

    addToPlaylistButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            var playlistId = button.getAttribute('data-playlist-id');
            var playlistContainer = document.querySelector('#playlistContainer[data-playlist-id="' + playlistId + '"]');

            // Ẩn tất cả các playlist khác
            var allPlaylistContainers = document.querySelectorAll('#playlistContainer');
            allPlaylistContainers.forEach(function (container) {
                if (container !== playlistContainer) {
                    container.classList.add('hidden');
                }
            });

            // Hiển thị hoặc ẩn playlist hiện tại
            if (playlistContainer.classList.contains('hidden')) {
                playlistContainer.classList.remove('hidden');
            } else {
                playlistContainer.classList.add('hidden');
            }

            // Ngăn chặn sự kiện click lan toả và mở rộng
            event.stopPropagation();
        });
    });

    // Đóng playlist khi click ra ngoài
    document.addEventListener('click', function (event) {
        var targetElement = event.target;

        // Kiểm tra xem sự kiện click có xảy ra trên playlist hay không
        var isPlaylistClick = targetElement.classList.contains('addToPlaylistButton') ||
            targetElement.closest('#playlistContainer') !== null;

        if (!isPlaylistClick) {
            var allPlaylistContainers = document.querySelectorAll('#playlistContainer');
            allPlaylistContainers.forEach(function (container) {
                container.classList.add('hidden');
            });
        }
    });
});