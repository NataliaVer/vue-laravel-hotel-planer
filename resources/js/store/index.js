
import { createStore } from 'vuex'
import Hotel from './modules/Hotel'
import Lang from './modules/Lang'
import Guest from './modules/Guest'

// Create a new store instance.
const store = createStore({
  modules: {
    Hotel: Hotel,
    Lang: Lang,
    Guest: Guest,
  }
})

// Install the store instance as a plugin
export default store;