<template>
  <div>
    <card :title="$t('books_list')">
      <template v-slot:add-btn>
        <router-link to="/book/add" class="btn btn-success btn-sm float-right"
          >Add New Book</router-link
        >
      </template>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">{{ $t("name") }}</th>
              <th scope="col">{{ $t("price") }}</th>
              <th scope="col">{{ $t("author_name") }}</th>
              <th scope="col">{{ $t("published_on") }}</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="book in books" :key="book.id">
              <td>{{ book.name }}</td>
              <td>Rs. {{ book.price }}</td>
              <td>
                <a href="#" @click="openModal(book.author)">{{
                  book.author.name
                }}</a>
              </td>
              <td>{{ book.published_on }}</td>
              <td>
                <router-link :to="{ name: 'books.edit', params: { id: book.id } }" class="btn btn-info">
                  {{ $t("edit") }}
                </router-link>
                <button @click="onDelete(book.id)" class="btn btn-danger">
                  {{ $t("delete") }}
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </card>
    <Modal v-if="showModal" :title="selectedAuthor.name+'\'s Details'" @close="closeModal()">
      <template v-slot:body>
        <div class="table-responsive">
          <table class="table">
            <tbody>
              <tr>
                <td>
                  <strong>
                    Name
                  </strong>
                </td>
                <td class="text-primary">
                  {{ selectedAuthor.name }}
                </td>
              </tr>
              <tr>
                <td>
                  <strong>
                    Email
                  </strong>
                </td>
                <td class="text-primary">
                  {{ selectedAuthor.email }}
                </td>
              </tr>
              <tr>
                <td>
                  <strong>
                    Mobile
                  </strong>
                </td>
                <td class="text-primary">
                  {{ selectedAuthor.mobile }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </template>
    </Modal>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import Swal from "sweetalert2";
import i18n from "~/plugins/i18n";

export default {
  middleware: "auth",
  data: function () {
    return {
      showModal: false,
      selectedAuthor: null,
    };
  },
  computed: mapGetters({
    books: "book/books",
  }),
  async created() {
    // Fetch the books.
    if(!this.books){
      await this.$store.dispatch("book/fetchBooks");
    }
  },
  methods: {
    onDelete(bookId) {
      Swal.fire({
        type: "warning",
        title: i18n.t("delete"),
        text: i18n.t("confirmation"),
        reverseButtons: true,
        confirmButtonText: i18n.t("ok"),
        cancelButtonText: i18n.t("cancel"),
      }).then(async () => {
        await this.$store.dispatch("book/deleteBook", bookId);
      });
    },
    openModal(author) {
      this.showModal = true;
      this.selectedAuthor = author;
    },
    closeModal() {
      this.showModal = false;
      this.selectedAuthor = null;
    },
  },
};
</script>

<style scoped>
.inf-content {
  border: 1px solid #dddddd;
  -webkit-border-radius: 10px;
  -moz-border-radius: 10px;
  border-radius: 10px;
  box-shadow: 7px 7px 7px rgba(0, 0, 0, 0.3);
}
</style>
