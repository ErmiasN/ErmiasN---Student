//Your library code goes in this file.

function ajaxRequest(url, Type, Parameters){
  var req = new XMLHttpRequest();
  if(!req){
    throw 'Unable to create XMLHttpRequest.';
  }
  
  if(Type === 'GET'){
    url += '?' + urlStringify(params);
    req.open('GET', url);
    req.send();
  }

  if(Type === 'POST'){
    req.open('POST', url);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send('Parameters=' + encodeURIComponent(Parameters));
  }
  
  var SuccessObj = {};
  req.onreadystatechange = function(){
    if(req.readyState === 4){
      if(req.status === 200){
        SucessObj.sucess = true;
      }
      else{
        SuccessObj.sucess = false;
      }
      SucessObj.code = req.status;
      SucessObj.codeDetail = req.statusText;
      SucessObj.response = req.responseText;
    }
  };
  
  return SucessObj;
}


function urlStringify(obj){
  var str = []
  for(var prop in obj){
    var s = encodeURIComponent(prop) + '=' + encodeURIComponent(obj[prop]);
    str.push(s);
  }
  return str.join('&');
}

function localStorageExists(){
  localStorage.setItem('itWorks', 'Lets test local storage!!');
  if(localStorage.getItem('itWorks') === 'Lets test local storage!!'){
    return true;
  }
  else{
    return false;
  }
}
