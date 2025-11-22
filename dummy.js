async function getRandomJoke() {
  const response = await fetch('https://official-joke-api.appspot.com/jokes/random');
  const joke = await response.json();
  return `${joke.setup}\n${joke.punchline}`;
}

getRandomJoke().then(console.log);
