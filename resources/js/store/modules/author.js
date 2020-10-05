import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  authors: null
}

// getters
export const getters = {
  authors: state => state.authors
}

// mutations
export const mutations = {
  [types.FETCH_AUTHOR_SUCCESS] (state, { authors }) {
    state.authors = authors
  },
  [types.FETCH_AUTHOR_FAILURE] (state) {
    state.authors = null;
  },
  [types.DELETE_AUTHOR_SUCCESS] (state, { removedAuthorID }) {
    let authorIndex = state.authors.findIndex(author => {
      return author.id == removedAuthorID;
    });
    state.authors.splice(authorIndex, 1);
  },
  [types.ADD_AUTHOR_SUCCESS] (state, {author}){
    state.authors.push(author);
  }
}

export const actions = {
  async fetchAuthors({ commit }){
    try {
      const { data } = await axios.get('/api/author')
      commit(types.FETCH_AUTHOR_SUCCESS, { authors: data })
    } catch (e) {
      commit(types.FETCH_AUTHOR_FAILURE)
    }
  },

  async deleteAuthor({commit}, authorId){
    await axios.delete('/api/author/'+authorId);
    commit(types.DELETE_AUTHOR_SUCCESS, { removedAuthorID: authorId })
  },

  async addAuthor({commit}, author){
    commit(types.ADD_AUTHOR_SUCCESS, {author: author});
  }
}

