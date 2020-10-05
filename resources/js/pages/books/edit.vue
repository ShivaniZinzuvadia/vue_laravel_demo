<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('book_edit')">
        <form @submit.prevent="update" @keydown="form.onKeydown($event)">
          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
            <div class="col-md-7">
              <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
              <has-error :form="form" field="name" />
            </div>
          </div>

          <!-- Price -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('price') }}</label>
            <div class="col-md-7">
              <input v-model="form.price" :class="{ 'is-invalid': form.errors.has('price') }" step=".01" class="form-control" type="number" name="price">
              <has-error :form="form" field="price" />
            </div>
          </div>

          <!-- Published On -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('published_on') }}</label>
            <div class="col-md-7">
              <datepicker v-model="form.published_on" :input-class="['form-control', {'is-invalid': form.errors.has('published_on')} ]"
               :disabledDates="disabledDates" name="published_on" format="yyyy-MM-dd" @selected="dateSelected"></datepicker>
               <has-error :form="form" field="published_on" />
            </div>
          </div>

          <!-- Author -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('author_name') }}</label>
            <div class="col-md-7">
              <select v-model="form.author_id" class="form-control" :class="{ 'is-invalid': form.errors.has('author_id') }" name="author_id">
                <option value="">Select Author</option>
                <option v-for="(author,index) in authors" :value="author.id" :key="index">{{author.name}}</option>
              </select>
              <has-error :form="form" field="author_id" />
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
import Datepicker from 'vuejs-datepicker';
export default {
  middleware: 'auth',
  components: { Datepicker },
  data: function () {
    return {
      bookId: "",
      book: null,
      form: new Form({
        name: '',
        price: '',
        author_id: '',
        published_on: ''
      }),
      isPublishedDateChanged: false,
      disabledDates: {
        from: new Date()
      }
    };
  },
  methods: {
    async update(){
      //Update published date format
      if(typeof(this.form.published_on) == Object){
        let selectedPublishDate = this.form.published_on;
        this.form.published_on = selectedPublishDate.getFullYear()+"-"+(selectedPublishDate.getMonth()+1)+"-"+selectedPublishDate.getDay();
      }

      // Submit the form.
      const { data } = await this.form.put('/api/book/'+this.bookId);

      this.$router.push('/books');
    },
    dateSelected(){
      this.isPublishedDateChanged = true;
    }
  },
  computed: {
    ...mapGetters({
      authors: "author/authors",
      books: "book/books"
    }),
  },
  async created() {
    if (!this.authors) {
      await this.$store.dispatch("author/fetchAuthors");
    }
    if(!this.books) {
      await this.$store.dispatch("book/fetchBooks");
    }

    this.bookId = this.$route.params.id;
    this.book = this.books.find((item) => {
      return item.id == this.bookId;
    });
    this.form.name = this.book.name;
    this.form.price = this.book.price;
    this.form.author_id = this.book.author.id;
    this.form.published_on = this.book.published_on;
  },
};
</script>

<style scoped>
input,
select {
  padding: 0.5em;
  font-size: 100%;
  border: 1px solid #ccc;
  width: 100%;
}
</style>
