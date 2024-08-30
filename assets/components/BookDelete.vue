<!-- src/components/BookDelete.vue -->
<template>
    <div>
      <h2>Are you sure you want to delete this book?</h2>
      <p><strong>Title:</strong> {{ book.title }}</p>
      <button @click="deleteBook">Yes, Delete</button>
      <button @click="$emit('cancel')">Cancel</button>
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
    methods: {
      deleteBook() {
        fetch(`/api/book/${this.book.id}`, {
          method: 'DELETE',
        })
          .then(() => {
            this.$emit('book-deleted');
          })
          .catch((error) => console.error('Error deleting book:', error));
      },
    },
  };
  </script>
  
  <style scoped>
  p {
    margin: 8px 0;
  }
  </style>
  