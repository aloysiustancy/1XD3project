async function fetchQuote(){
    const response = await fetch("https://api.quotable.io/random");
    const data = await response.json();
    console.log(data);
    const quote=data[0].q; // get the quote text
    const author=data[0].a; // get the author name
    document.getElementById("quote").textContent = `"${quote}"`;
    document.getElementById("author").textContent = `- ${author}`;
}