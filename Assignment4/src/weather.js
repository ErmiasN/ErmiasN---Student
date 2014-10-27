function saveSettings(){
  localStorage.setItem('city', document.getElementById('city').value);
  localStorage.setItem('state', document.getElementById('state').value);
  localStorage.setItem('wind', document.getElementById('wind').checked);
  localStorage.setItem('maxTemp', document.getElementById('maxTemp').checked);
  localStorage.setItem('minTemp', document.getElementById('minTemp').checked);
  localStorage.setItem('currentTemp', document.getElementById('currentTemp').checked);
}

window.onload = function(){
  document.getElementById('city').value = localStorage.getItem('city');
  document.getElementById('state').value = localStorage.getItem('state');

  if(localStorage.getElementById('wind') === 'true'){
      document.getElementById('wind').checked = true;
  }
  else
     document.getElementById('wind').checked = true;  


  if(localStorage.getElementById('maxTemp') === 'true'){
      document.getElementById('maxTemp').checked = true;
  }
  else
     document.getElementById('maxTemp').checked = true;  


  if(localStorage.getElementById('minTemp') === 'true'){
      document.getElementById('minTemp').checked = true;
  }
  else
     document.getElementById('minTemp').checked = true;  


  if(localStorage.getElementById('currentTemp') === 'true'){
      document.getElementById('currentTemp').checked = true;
  }
  else
     document.getElementById('currentTemp').checked = true;  
}


function tomorrowForecast(){
  var req = new XMLHttpRequest();
  
  if(!req){
    throw 'Unable to create HttpRequest!';
  }

  var citySelect = document.getElementById('city').value;
  var url = 'http://api.openweathermap.org/data/2.5/weather';

  var params ={
    q: document.getElementById('city').value + ',' + document.getElementById('state').value,
    mode: 'json',
    units: 'imperial'
  };

  url += '?' + urlStringify(params);


  req.onreadystatechange = function tomorrowWeather(){
    if(req.readyState === 4){
      if(req.readyStatus === 200){
        var weather = JSON.parse(req.responseText);
        var windSpeed = weather.wind.speed;
        var windDeg = weather.wind.deg;
        var maxTemp = weather.main.temp_max;
        var minTemp = weather.main.temp_min;
        var currentTemp = weather.main.temp;
      }
    }
  }
  req.open('GET', url);
  req.send();
}

function urlStringify(obj){
  var str = []
  for(var prop in obj){
    var s = encodeURIComponent(prop) + '=' + encodeURIComponent(obj[prop]);
    str.push(s);
  }
  return str.join('&');
}
