import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  books: null
}

// getters
export const getters = {
  books: state => state.books
}

// mutations
export const mutations = {
  [types.FETCH_BOOK_SUCCESS] (state, { books }) {
    state.books = books
  },
  [types.FETCH_BOOK_FAILURE] (state) {
    state.books = null;
  },
  [types.DELETE_BOOK_SUCCESS] (state, { removedBookID }) {
    let bookIndex = state.books.findIndex(book => {
      return book.id == removedBookID;
    });
    state.books.splice(bookIndex, 1);
  },
  [types.ADD_BOOK_SUCCESS] (state, {book}){
    state.books.push(book);
  }
}

export const actions = {
  async fetchBooks({ commit }){
    try {
      const { data } = await axios.get('/api/book')
      commit(types.FETCH_BOOK_SUCCESS, { books: data })
    } catch (e) {
      commit(types.FETCH_BOOK_FAILURE)
    }
  },

  async deleteBook({ commit }, bookId){
    await axios.delete('/api/book/'+bookId);
    commit(types.DELETE_BOOK_SUCCESS, { removedBookID: bookId })
  },

  async addBook({commit}, book){
    commit(types.ADD_BOOK_SUCCESS, {book: book});
  }
}

