<template>
  <div>
    <card :title="$t('authors_list')">
      <template v-slot:add-btn>
        <router-link to="/authors/add" class="btn btn-success btn-sm float-right"
          >Add New Author</router-link
        >
      </template>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">{{ $t("name") }}</th>
              <th scope="col">{{ $t("email") }}</th>
              <th scope="col">{{ $t("mobile") }}</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="author in authors" :key="author.id">
              <td>{{ author.name }}</td>
              <td>{{ author.email }}</td>
              <td>{{ author.mobile }}</td>
              <td>
                <router-link
                  :to="{ name: 'authors.edit', params: { id: author.id } }"
                  class="btn btn-info"
                >
                  {{ $t("edit") }}
                </router-link>
                <button @click="onDelete(author.id)" class="btn btn-danger">
                  {{ $t("delete") }}
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </card>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import Swal from "sweetalert2";
import i18n from "~/plugins/i18n";

export default {
  middleware: "auth",
  computed: mapGetters({
    authors: "author/authors",
  }),
  async created() {
    // Fetch the user.
    if(!this.authors){
      await this.$store.dispatch("author/fetchAuthors");
    }
  },
  methods: {
    onDelete(authorId) {
      Swal.fire({
        type: "warning",
        title: i18n.t("delete"),
        text: i18n.t("confirmation"),
        reverseButtons: true,
        confirmButtonText: i18n.t("ok"),
        cancelButtonText: i18n.t("cancel"),
      }).then(async () => {
        await this.$store.dispatch("author/deleteAuthor", authorId);
      });
    },
  },
};
</script>
