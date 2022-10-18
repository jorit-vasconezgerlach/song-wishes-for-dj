const onDevelopment = true;

window.addEventListener('load', ()=>{

          const songList = document.querySelector('#songList');
          
          const searchForm = document.querySelector('#search form');
          const searchFormInput = searchForm.querySelector('input[type=text]');
          
          searchFormInput.addEventListener('keyup', ()=>{
                    search(searchFormInput.value.replace(' ', '%20'));
          });
          searchForm.addEventListener('submit', ()=>{
                    search(searchFormInput.value.replace(' ', '%20'));
          });
          
          function search(searchValue) {
          
                    songList.innerHTML = "searching...";
          
                    // Set Data as JSON
                    var data = {
                              search: searchValue
                    };
          
                    // Create XHR Request
                    var xhr = new XMLHttpRequest();
          
                    // Setup XHR Request
                    var xhrURL = "https://tools.vasconezgerlach.de/dj-song-wishes/backend/";
                    xhr.open("POST", xhrURL, true);
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    // On XHR Request Change
                    xhr.onreadystatechange = function () {
                              // On XHR Ready
                              if (xhr.readyState === 4) {
                                        // clear searching
                                        songList.innerHTML = "";
                                        // get XHR response
                                        var jsonResponse = JSON.parse(xhr.responseText);
                                        // XHR response validation
                                        if(jsonResponse.error === false) {
                                                  var searchResult = JSON.parse(jsonResponse['out']);
                                        // Continue with search variable
                                        if(searchResult.total === 0) {
                                                  songList.innerHTML = "Nothing found!";
                                        } else {
                                                  fillPage(searchResult);
                                        }
                                        } else {
                                                  console.warn('API error');
                                        }
                              }
                    };
                    // Send XHR Request
                    xhr.send(JSON.stringify(data));
          
          }

          function fillPage(JSON) {
                    console.groupCollapsed('elements searched for:');
                    JSON.data.forEach(element => {
                              console.table(element);
                              var newSong = Object.assign(document.createElement('div'), {
                                        className: "song"
});
                              newSong.innerHTML = `
                                        <img src="${element.album.cover_small}"></img>
                                        <span class="divider"></span>
                                        <div class="text">
                                                  <h4>${element.title}</h4>
                                                  <span>${element.artist.name}</span>
                                        </div>
                                        <span class="divider"></span>
                                        <span>${(element.duration / 60).toFixed(2).replace('.',':')}</span>
                                        <span class="divider"></span>
                                        <div class="controls">
                                                  <div class="control player outline" onclick="player(this)"></div>
                                                  <audio controls>
                                                            <source src="${element.preview}" type="audio/mpeg">
                                                  </audio>
                                                  <button class="control" onclick="saveTrack(${element.id})"></button>
                                        </div>
                              `;
                              songList.append(newSong);
                    });
                    console.groupEnd();
          }
          
          if(onDevelopment) {
                    search('Hello%20World');
          }

});

function player(el) {
          if(el.parentNode.querySelector('audio').paused) {
                    pauseAll();
                    el.classList.toggle('playing');
                    el.parentNode.querySelector('audio').play();
          } else{
                    el.classList.toggle('playing');
                    el.parentNode.querySelector('audio').pause();
          }
}

function pauseAll() {
          var allAudioEls = document.querySelectorAll('audio');
          allAudioEls.forEach(element => {
                    element.pause();
                    element.parentNode.querySelector('.player').classList.remove('playing');
          });
}