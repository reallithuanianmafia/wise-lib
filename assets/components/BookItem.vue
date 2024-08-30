<template>
  <li>
    <div>
      <strong>{{ book.title }}</strong> by {{ book.author }} (ISBN: {{ book.isbn }})
    </div>
    <button @click="$emit('edit', book)">Edit</button>
    <button @click="$emit('delete', book.id)">Delete</button>
  </li>
</template>

<script>
export default {
  props: {
    book: {
      type: Object,
      required: true
    }
  }
};
</script>
