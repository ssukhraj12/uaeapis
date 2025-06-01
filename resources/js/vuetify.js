import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import * as colors from "vuetify/util/colors";

export default createVuetify({
    components,
    directives,
    theme:{
        defaultTheme:'light',
        themes:{
            light:{
                colors:{
                    primary:colors.blue.darken3
                }
            }
        }
    }
})
