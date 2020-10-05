<template>
  <div class="card">
    <div v-if="title" class="card-header">
      {{ title }}
      <slot name="add-btn">
      </slot>
    </div>

    <div class="card-body">
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  name: 'Card',

  props: {
    title: { type: String, default: null }
  }
}
</script>
