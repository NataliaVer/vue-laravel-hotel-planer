<template>
    <div class="wrapper">
  <div class="text_group">
    <p class="text_404">404</p>
    <p class="text_lost">The page you are looking for <br />has been lost in space.</p>
  </div>
</div>
</template>

<script>

export default {
    name: 'NotFound'
}
</script>

<style>
.wrapper {
  min-width: 80vw;
  min-height: 60vh;
  text-align: center;
  align-items: center;
  .text_group {
    .text_404 {
      font-family: cursive;
      font-size: 10em;
      box-sizing: border-box;
      color: #363636;
    }
    .text_lost {
      font-family: cursive;
      font-size: 2em;
      line-height: 50px;
      box-sizing: border-box;
      color: #565656;
    }
  }
  }
</style>