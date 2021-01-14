random = {};
nbr_random = 0;

function play_pause(){
    let music = document.getElementById('lecteur');
    if(music.paused){
        music.play();
        document.getElementById("play").className="flaticon-141-pause";
    }
    else{
        music.pause();
        document.getElementById("play").className="flaticon-146-play";
    }
}

function liste_musiques(){
    let cases = document.getElementById('nbr_musics').textContent;
    let musics = [];
    for(let i=0;i<cases;i++){
        let j = i + 1;
        musics[i] = document.getElementById('music_num'+j).textContent;
    }
    return(musics);
}

function music_clic(music){
    let lecteur = document.getElementById('lecteur');
    let title = document.getElementById('footer__music-infos__title');
    let artist = document.getElementById('footer__music-infos__artist');
    let nom_music = music.id;
    lecteur.src = "mp3/"+nom_music;
    lecteur.className = "mp3/"+nom_music;
    title.textContent = music.getElementsByTagName('td')[0].textContent;
    artist.textContent = music.getElementsByTagName('td')[1].textContent;
    play_pause();
    music_color();
}


function play_random(bouton){
    let class_value = bouton.className;
    let random_value = parseInt(class_value);

    if(random_value===1){
        random_value=2;
        bouton.className = "2";
        random_table();
    }
    else if(random_value===2){
        random_value=1;
        bouton.className = "1";
    }

    if(random_value===1){
        bouton.src = "https://img.icons8.com/windows/96/c0c0c0/shuffle.png";
    }
    else if(random_value===2){
        bouton.src = "https://img.icons8.com/windows/96/0072bb/shuffle.png";
    }
}

function random_table(){
    window.random = {};
    window.nbr_random = 0;
    let nbr = document.getElementById("nbr_musics").textContent;
    nbr = parseInt(nbr);
    let array = [];

    for(let i=1; i<nbr+1; i++){
        let j = i-1;
        array[j] = i;
    }
    shuffle(array);
    window.random = array;
}
function shuffle(array){
    return array.sort(() => Math.random() -0.5);
}

function play_loop(bouton){
    let class_value = bouton.className;
    let loop_value = parseInt(class_value);

    if(loop_value===1){
        loop_value=2;
        bouton.className="2";
    }
    else if(loop_value===2){
        loop_value=3;
        bouton.className="3";
    }
    else if(loop_value===3){
        loop_value=1;
        bouton.className="1";
    }

    if(loop_value===1){
        bouton.src = "https://img.icons8.com/windows/96/c0c0c0/repeat.png";
    }
    else if(loop_value===2){
        bouton.src = "https://img.icons8.com/windows/96/0072bb/repeat.png";
    }
    else if(loop_value===3){
        bouton.src = "https://img.icons8.com/windows/96/0072bb/repeat-one.png";
    }
}

function defilement_musics_test(value){
    let loop_value = document.getElementById('loop').className;
    let random_value = document.getElementById('random').className;
    loop_value = parseInt(loop_value);
    random_value = parseInt(random_value);

    if(loop_value===1){
        if(random_value===2){
            if(value===2){value=1;}
            defilement_musics_random(value);
        }
        else{
            if(value===1 || value===-1){
                defilement_musics_loop_on(value);
            }
            else if(value===2){
                value=1;
                defilement_musics_loop_off(value);
            }
        }
    }
    else if(loop_value===2){
        if(value===2){value=1;}
        if(random_value===2){
            defilement_musics_random(value);
        }
        else{
            defilement_musics_loop_on(value);
        }
    }
    else if(loop_value===3){
        defilement_musics_loop_on(0);
    }
}

function defilement_musics_random(value){
    let musics = liste_musiques();
    let cases = document.getElementById('nbr_musics').textContent;
    let title = document.getElementById('footer__music-infos__title');
    let artist = document.getElementById('footer__music-infos__artist');
    cases = parseInt(cases);
    let lecteur = document.getElementById('lecteur');
    let id;

    if((value===-1 && window.nbr_random===0) || (value===1 && window.nbr_random===cases)){
        lecteur.src = "mp3/"+musics[window.random[0]];
        lecteur.className = "mp3/"+musics[window.random[0]];
        id = document.getElementById(musics[window.random[0]]);
    }
    else{
        window.nbr_random += value;
        lecteur.src = "mp3/"+musics[window.random[window.nbr_random]];
        lecteur.className = "mp3/"+musics[window.random[window.nbr_random]];
        id = document.getElementById(musics[window.random[window.nbr_random]]);
    }
    title.textContent = id.getElementsByTagName('td')[0].textContent;
    artist.textContent = id.getElementsByTagName('td')[1].textContent;
    play_pause();
    music_color();
}

function defilement_musics_loop_on(value){
    let musics = liste_musiques();
    let cases = document.getElementById('nbr_musics').textContent;
    let title = document.getElementById('footer__music-infos__title');
    let artist = document.getElementById('footer__music-infos__artist');
    cases = parseInt(cases);
    let lecteur = document.getElementById('lecteur');
    let id;

    for(let i=0; i<cases; i++){
        if("mp3/"+musics[i] === lecteur.className){
            if((value===-1 && i===0) || (value===1 && i===cases-1)){
                lecteur.src = "mp3/"+musics[0];
                lecteur.className = "mp3/"+musics[0];
                id = document.getElementById(musics[0]);
            }
            else{
                lecteur.src = "mp3/"+musics[i+value];
                lecteur.className = "mp3/"+musics[i+value];
                id = document.getElementById(musics[i+value]);
            }
            title.textContent = id.getElementsByTagName('td')[0].textContent;
            artist.textContent = id.getElementsByTagName('td')[1].textContent;
            play_pause();
            music_color();
            break;
        }
    }
}

function defilement_musics_loop_off(value){
    let musics = liste_musiques();
    let cases = document.getElementById('nbr_musics').textContent;
    let title = document.getElementById('footer__music-infos__title');
    let artist = document.getElementById('footer__music-infos__artist');
    cases = parseInt(cases);
    let lecteur = document.getElementById('lecteur');
    let id;

    for(let i=0; i<cases; i++){
        if("mp3/"+musics[i] === lecteur.className){
            if(i===cases-1){
                lecteur.src = "mp3/"+musics[i];
                lecteur.className = "mp3/"+musics[i];
                id = document.getElementById(musics[i]);
                play_pause();
            }
            else{
                lecteur.src = "mp3/"+musics[i+value];
                lecteur.className = "mp3/"+musics[i+value];
                id = document.getElementById(musics[i+value]);
            }
            title.textContent = id.getElementsByTagName('td')[0].textContent;
            artist.textContent = id.getElementsByTagName('td')[1].textContent;
            play_pause();
            music_color();
            break;
        }
    }
}

function premiere_musique(){
    display_playlist_title();
    let musics = liste_musiques();
    let lecteur = document.getElementById('lecteur');
    let title = document.getElementById('footer__music-infos__title');
    let artist = document.getElementById('footer__music-infos__artist');
    let id;

    lecteur.src = "mp3/"+musics[0];
    lecteur.className = "mp3/"+musics[0];
    lecteur.currentTime = 0;
    id = document.getElementById(musics[0]);
    title.textContent = id.getElementsByTagName('td')[0].textContent;
    artist.textContent = id.getElementsByTagName('td')[1].textContent;
    music_color();
    playlist_color();
}


function move(){
    document.addEventListener("mousemove", progress_bar_clic);
    document.addEventListener("mouseup", function(){
        document.removeEventListener("mousemove", progress_bar_clic);
    });
}
function progress_bar_clic(){
    let lecteur = document.getElementById('lecteur');
    let x = event.clientX - (document.getElementById('cover').offsetWidth+document.getElementById('footer__progress-bar').offsetLeft);
    let duration = lecteur.duration;
    let percent = (x / 500);
    lecteur.currentTime = percent * duration;
    update(lecteur);
}


function display_playlist_title(){
    let display = document.getElementById('display-playlist-title__span');
    let id = document.getElementById('playlist_num').textContent;

    display.textContent = document.getElementById(id).textContent;
}

function music_color(){
    let musics = liste_musiques();
    let cases = document.getElementById('nbr_musics').textContent;
    cases = parseInt(cases);
    let lecteur = document.getElementById('lecteur');
    let id;

    for(let i=0; i<cases; i++){
        id = document.getElementById(musics[i]);
        if("mp3/"+musics[i] === lecteur.className){
            id.style.color = "#0072BB";
        }
        else{
            id.style.color = "#C0C0C0";
        }
    }
}

function playlist_color(){
    let playlist_nbr = document.getElementById('playlist_nbr').textContent;
    let playlist_num = document.getElementById('playlist_num').textContent;
    let id;

    for(let i=0; i<playlist_nbr+1; i++){
        id = document.getElementById('playlist'+i);
        if(playlist_num === "playlist"+i){
            id.style.color = "#0072BB";
        }
        else{
            id.style.color = "#C0C0C0";
        }
    }
}


function vol(){
    document.addEventListener("mousemove", vol2);
    document.addEventListener("mouseup", function(){
        document.removeEventListener("mousemove", vol2);
    });
}
function vol2(){
    let x = event.clientX;
    let decalage = document.getElementById('cover').offsetWidth+document.getElementById('footer__volume').offsetLeft+document.getElementById('footer__volume__range').offsetLeft+document.getElementById('footer__volume__progress-range').offsetLeft;
    x -= decalage;
    let range = document.getElementById('progressRange');
    range.style.width = x + "px";
    x /= 2;
    volume(x);
}
function volume(vol){
    let music = document.getElementById('lecteur');
    let image = document.getElementById('son');
    vol /= 100;
    music.volume = vol;
    vol = Math.ceil(vol*100);

    if(vol >= 60){
        image.src = "https://img.icons8.com/windows/96/c0c0c0/high-volume.png";
        }
    else if(vol >= 30 && vol < 60){
        image.src = "https://img.icons8.com/windows/96/c0c0c0/medium-volume.png";
        }
    else if(vol > 0 && vol < 30){
        image.src = "https://img.icons8.com/windows/96/c0c0c0/low-volume.png";
        }
    else if(vol === 0){
        image.src = "https://img.icons8.com/windows/96/c0c0c0/mute.png";
        }
}

function btn_volume(){
    let vol = document.getElementById('lecteur').volume;
    vol = Math.ceil(vol*100);
    if(vol!==0){
        volume(0);
    }
    else{
        volume(50);
        let range = document.getElementById('progressRange');
        range.style.width = 100 + "px";
    }
}


function update(player){
    let duration = player.duration;    // Durée totale
    let time     = player.currentTime; // Temps écoulé
    let fraction = time / duration;
    let percent  = Math.ceil(fraction * 500);
    let progress = document.getElementById('progressBar');
    progress.style.width = percent + "px";
    document.getElementById('progressTime').textContent = formatTime(time)+" / "+formatTime(duration);

    if(player.ended){
        defilement_musics_test(2);
    }
}

function formatTime(time) {
    let hours = Math.floor(time / 3600);
    let mins  = Math.floor((time % 3600) / 60);
    let secs  = Math.floor(time % 60);
    if (secs < 10) {
        secs = "0" + secs;
    }
    if(hours){
        if(mins < 10){
            mins = "0" + mins;
        }
        return hours + ":" + mins + ":" + secs; // hh:mm:ss
    }
    else{
        return mins + ":" + secs; // mm:ss
    }
}
