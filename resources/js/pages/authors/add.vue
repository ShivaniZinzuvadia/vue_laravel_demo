<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('author_add')">
        <form @submit.prevent="add" @keydown="form.onKeydown($event)">
          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
            <div class="col-md-7">
              <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
              <has-error :form="form" field="name" />
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
                {{ $t('add') }}
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
      form: new Form({
        name: '',
        email: '',
        mobile: ''
      }),
    };
  },
  methods: {
    async add(){
       // Submit the form.
      const { data } = await this.form.post('/api/author');

      this.$store.dispatch("author/addAuthor", data);

      this.$router.push('/authors');
    }
  }
};
</script>
