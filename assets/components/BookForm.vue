<template>
  <div class="container mt-4">
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">
        <h3>{{ editBook ? 'Edit Book' : 'Add New Book' }}</h3>
      </div>
      <div class="card-body">
        <form @submit.prevent="handleSubmit">
          <!-- Title -->
          <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input
              id="title"
              v-model="formData.title"
              type="text"
              class="form-control"
              placeholder="Enter book title"
              required
            />
          </div>
          
          <!-- Author -->
          <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input
              id="author"
              v-model="formData.author"
              type="text"
              class="form-control"
              placeholder="Enter author name"
              required
            />
          </div>

          <!-- ISBN -->
          <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input
              id="isbn"
              v-model="formData.isbn"
              type="text"
              class="form-control"
              placeholder="Enter ISBN"
              required
            />
          </div>

          <!-- Publication Date -->
          <div class="mb-3">
            <label for="publicationDate" class="form-label">Publication Date</label>
            <input
              id="publicationDate"
              v-model="formData.publicationDate"
              type="date"
              class="form-control"
              required
            />
          </div>

          <!-- Genre -->
          <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input
              id="genre"
              v-model="formData.genre"
              type="text"
              class="form-control"
              placeholder="Enter genre"
              required
            />
          </div>

          <!-- Number of Copies -->
          <div class="mb-3">
            <label for="numberOfCopies" class="form-label">Number of Copies</label>
            <input
              id="numberOfCopies"
              v-model="formData.numberOfCopies"
              type="number"
              class="form-control"
              placeholder="Enter number of copies"
              required
              min="1"
            />
          </div>

          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success me-2">{{ editBook ? 'Update' : 'Save' }}</button>
            <button type="button" @click="$emit('cancel')" class="btn btn-secondary">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    editBook: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      formData: {
        title: '',
        author: '',
        isbn: '',
        publicationDate: '',
        genre: '',
        numberOfCopies: 1
      }
    };
  },
  watch: {
    editBook: {
      immediate: true,
      handler(newValue) {
        if (newValue) {
          this.formData = { ...newValue };
        } else {
          // Reset form data for new book
          this.formData = {
            title: '',
            author: '',
            isbn: '',
            publicationDate: '',
            genre: '',
            numberOfCopies: 1
          };
        }
      }
    }
  },
  methods: {
    async handleSubmit() {
      const url = this.editBook ? `/api/books/${this.editBook.id}` : '/api/books';
      const method = this.editBook ? 'PUT' : 'POST';

      try {
        const response = await fetch(url, {
          method,
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.formData)
        });

        if (response.ok) {
          this.$emit('form-submit');
          this.$emit('cancel');
        } else {
          const errorData = await response.json();
          alert(`Error saving book: ${errorData.error || 'Please try again.'}`);
        }
      } catch (error) {
        console.error('Error:', error);
        alert('Error saving book. Please try again.');
      }
    }
  }
};
</script>

<style scoped>
.card {
  max-width: 600px;
  margin: auto;
}
</style>
