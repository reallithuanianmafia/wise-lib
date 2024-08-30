<template>
  <div>
    <!-- Add New Book Button -->
    <div class="mb-3">
      <button @click="showAddForm" class="btn btn-primary">Add New Book</button>
    </div>

    <!-- Search Bar -->
    <div class="search-bar mb-3">
      <input
        type="text"
        v-model="searchQuery"
        @input="fetchBooks"
        placeholder="Search by title, author, or ISBN"
        class="form-control"
      />
    </div>

    <!-- Book Table -->
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Title</th>
          <th>Author</th>
          <th>ISBN</th>
          <th>Publication Date</th>
          <th>Genre</th>
          <th>Copies</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="book in books" :key="book.id">
          <td>{{ book.title }}</td>
          <td>{{ book.author }}</td>
          <td>{{ book.isbn }}</td>
          <td>{{ book.publicationDate }}</td>
          <td>{{ book.genre }}</td>
          <td>{{ book.numberOfCopies }}</td>
          <td>
            <button @click="editBook(book)" class="btn btn-warning btn-sm">Edit</button>
            <button @click="deleteBook(book.id)" class="btn btn-danger btn-sm">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <a class="page-link" @click="changePage(currentPage - 1)">Previous</a>
        </li>
        <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: page === currentPage }">
          <a class="page-link" @click="changePage(page)">{{ page }}</a>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <a class="page-link" @click="changePage(currentPage + 1)">Next</a>
        </li>
      </ul>
    </nav>

    <!-- Book Form -->
    <BookForm v-if="showForm" :editBook="selectedBook" @cancel="showForm = false" @form-submit="fetchBooks" />
  </div>
</template>

<script>
import axios from 'axios';
import BookForm from './BookForm.vue';

export default {
  components: { BookForm },
  data() {
    return {
      books: [],
      totalPages: 0,
      currentPage: 1,
      searchQuery: '',
      showForm: false,
      selectedBook: null,
    };
  },
  methods: {
    async fetchBooks() {
      try {
        const response = await axios.get('/api/books', {
          params: {
            page: this.currentPage,
            limit: 5,
            search: this.searchQuery
          }
        });
        this.books = response.data.books;
        this.totalPages = Math.ceil(response.data.total / 5); // Fix totalPages calculation
      } catch (error) {
        console.error('Error fetching books:', error);
      }
    },
    changePage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
        this.fetchBooks();
      }
    },
    showAddForm() {
      this.selectedBook = null;
      this.showForm = true;
    },
    editBook(book) {
      this.selectedBook = book;
      this.showForm = true;
    },
    async deleteBook(id) {
      if (confirm('Are you sure you want to delete this book?')) {
        try {
          await axios.delete(`/api/books/${id}`);
          this.fetchBooks();
        } catch (error) {
          console.error('Error deleting book:', error);
        }
      }
    }
  },
  mounted() {
    this.fetchBooks();
  }
};
</script>

<style scoped>
/* Add your custom styles here */
</style>
