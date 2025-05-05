<template>
    <div id="app">
      <Header />
      <main>
        <h1>Welcome to ArtHub!</h1>
        <p>Your gateway to art and culture.</p>
      </main>
      <Footer />
    </div>
  </template>
  
  <script>
  import Header from '/header.vue';
  import Footer from '/footer.vue';
  
  export default {
    name: 'App',
    components: {
      Header,
      Footer,
    },
  };
  </script>
  
  <style>
  #app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
  }
  
  main {
    margin: 20px;
  }
  </style>
  