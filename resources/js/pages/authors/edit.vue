<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('author_edit')">
        <form @submit.prevent="update" @keydown="form.onKeydown($event)">
          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
            <div class="col-md-7">
              <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
              <has-error :form="form" field="email" />
            </div>
          </div>

          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
            <div class="col-md-7">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
              <has-error :form="form" field="email" />
            </div>
          </div>


          <!-- Mobile -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('mobile') }}</label>
            <div class="col-md-7">
              <input v-model="form.mobile" :class="{ 'is-invalid': form.errors.has('mobile') }" class="form-control" type="text" name="mobile">
              <has-error :form="form" field="mobile" />
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button :loading="form.busy">
                {{ $t('edit') }}
              </v-button>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import { mapGetters } from "vuex";
export default {
  middleware: 'auth',
  data: function () {
    return {
      authorId: "",
      author: null,
      form: new Form({
        name: '',
        email: '',
        mobile: ''
      }),
    };
  },
  computed: {
    ...mapGetters({
      authors: "author/authors",
    }),
  },
  async created() {
    if (!this.authors) {
      await this.$store.dispatch("author/fetchAuthors");
    }
    this.authorId = this.$route.params.id;
    this.author = this.authors.find((item) => {
      return item.id == this.authorId;
    });
    this.form.name = this.author.name;
    this.form.email = this.author.email;
    this.form.mobile = this.author.mobile;
  },
  methods: {
    async update(){
      // Submit the form.
      const { data } = await this.form.put('/api/author/'+this.authorId);
      this.$router.push('/authors');
    }
  }
};
</script>
