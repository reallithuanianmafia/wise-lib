<!-- assets/components/BookDetail.vue -->
<template>
    <div v-if="book">
      <h2>Book Details</h2>
      <p><strong>Title:</strong> {{ book.title }}</p>
      <p><strong>Author:</strong> {{ book.author }}</p>
      <p><strong>ISBN:</strong> {{ book.isbn }}</p>
      <p><strong>Publication Date:</strong> {{ book.publicationDate }}</p>
      <p><strong>Genre:</strong> {{ book.genre }}</p>
      <p><strong>Number of Copies:</strong> {{ book.numberOfCopies }}</p>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      book: {
        type: Object,
        required: true,
      },
    },
  };
  </script>
  