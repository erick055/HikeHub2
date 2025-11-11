  //Weather API
  const apiKey = "bd048573dcf03e718013b6124431cf47";
  const apiUrl = "https://api.openweathermap.org/data/2.5/weather?units=metric&q=cavite";

 
  async function checkWeather() {
    
    const response = await fetch(apiUrl + `&appid=${apiKey}`);
    var data = await response.json();

      document.querySelector(".temp").innerHTML = Math.round(data.main.temp) + "°C";
      document.querySelector(".humid").innerHTML = data.main.humidity + "%";
      document.querySelector(".wind").innerHTML = data.wind.speed + " km/h";
    console.log(data);
  }
  checkWeather();

  