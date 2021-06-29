<template>
  <v-app>
    <v-app-bar
      app
      color="primary"
      dark
    >
      <div class="d-flex align-center">
        <v-img
          alt="Vuetify Logo"
          class="shrink mr-2"
          contain
          src="https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png"
          transition="scale-transition"
          width="40"
        />

        <v-img
          alt="Vuetify Name"
          class="shrink mt-1 hidden-sm-and-down"
          contain
          min-width="100"
          src="https://cdn.vuetifyjs.com/images/logos/vuetify-name-dark.png"
          width="100"
        />
      </div>

      <v-spacer></v-spacer>

    <router-link to="/register">
        <v-btn
            text
        >
            <span class="mr-2">Register</span>
            <v-icon>mdi-pencil</v-icon>
        </v-btn>
    </router-link>
    <router-link to="/login">
            <v-btn
                text
            >
                <span class="mr-2">Login</span>
                <v-icon>mdi-account</v-icon>
            </v-btn>
        </router-link>
    </v-app-bar>

    <v-main>
      <router-view/>
    </v-main>
      <v-fab-transition>
          <v-btn
              color="blue"
              fab
              large
              dark
              bottom
              left
              class="v-btn--example ml-3 mb-5"
              to="/create/thread"
          >
              <v-icon>mdi-pencil</v-icon>
          </v-btn>
      </v-fab-transition>
  </v-app>
</template>

<script>


export default {
  name: 'App',

  data: () => ({
    //
  }),

};
</script>
