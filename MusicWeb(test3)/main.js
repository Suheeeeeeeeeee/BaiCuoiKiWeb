const audio = document.getElementById("audio");
const title = document.getElementById("title");
const cover = document.getElementById("cover");

// Tiêu đề bài hát, tương ứng với các file mp3
const songs = ["Một Phút", "Một Ngày Chẳng Nắng", "Lan Man"];

// Lấy index bất kỳ trong mảng songs để hiện thị
let songIndex = 2;

// Load 1 bài hát theo index
loadSong(songs[songIndex]);

// Cập nhật thông tin bài hát
function loadSong(song) {
    title.innerText = song;
    audio.src = `music/${song}.mp3`;
    cover.src = `images/${song}.png`;
}
const musicContainer = document.getElementById("music-container");
const playBtn = document.getElementById("play");

// Play song
function playSong() {
    musicContainer.classList.add("play");
    playBtn.querySelector("i.fas").classList.remove("fa-play");
    playBtn.querySelector("i.fas").classList.add("fa-pause");

    audio.play();
}

// Pause song
function pauseSong() {
    musicContainer.classList.remove("play");
    playBtn.querySelector("i.fas").classList.add("fa-play");
    playBtn.querySelector("i.fas").classList.remove("fa-pause");

    audio.pause();
}

// Lắng nghe sự kiện
playBtn.addEventListener("click", () => {
    // Kiểm tra xem musicContainer có chứa class "play" hay không?
    const isPlaying = musicContainer.classList.contains("play");

    // Nếu có thì thực hiện pause
    // Nếu không thì thực hiện play
    if (isPlaying) {
        pauseSong();
    } else {
        playSong();
    }
});
const progress = document.getElementById("progress");
const progressContainer = document.getElementById("progress-container");

// Time/song update
audio.addEventListener("timeupdate", updateProgress);

// Click on progress bar
progressContainer.addEventListener("click", setProgress);

// Update progress bar
function updateProgress(e) {
    const { duration, currentTime } = e.srcElement;
    const progressPercent = (currentTime / duration) * 100;
    progress.style.width = `${progressPercent}%`;
}

// Set progress bar
function setProgress(e) {
    const width = this.clientWidth;
    const clickX = e.offsetX;
    const duration = audio.duration;

    audio.currentTime = (clickX / width) * duration;
}
const prevBtn = document.getElementById("prev");
const nextBtn = document.getElementById("next");

// Lắng nghe sự kiện khi next và prev bài hát
prevBtn.addEventListener("click", prevSong);
nextBtn.addEventListener("click", nextSong);

// Lắng nghe sự kiện khi kết thúc bài hát
audio.addEventListener("ended", nextSong);

// Xử lý khi prev bài hát
function prevSong() {
    // Giảm index của songIndex đi 1
    songIndex--;

    // Nếu đang là bài hát đầu thì quay lại bài hát cuối
    if (songIndex < 0) {
        songIndex = songs.length - 1;
    }

    // Cập nhật thông tin của bài hát lên giao diện
    loadSong(songs[songIndex]);

    // Phát nhạc
    playSong();
}

// Xử lý khi next bài hát
function nextSong() {
    // Tăng index của songIndex lên 1
    songIndex++;

    // Nếu đang là bài hát cuối thì quay lại bài hát đầu
    if (songIndex > songs.length - 1) {
        songIndex = 0;
    }

    // Cập nhật thông tin của bài hát lên giao diện
    loadSong(songs[songIndex]);

    // Phát nhạc
    playSong();
}