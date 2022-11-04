import { createApp } from 'vue';

// UIkit
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';
UIkit.use(Icons)

// object-fit
import objectFitImages from 'object-fit-images'
objectFitImages()

/* ----------------------------------------------------------

	CSS

---------------------------------------------------------- */
/*
	foundation
*/
/* common */
import './sass/foundation/common/header.scss'
import './sass/foundation/common/footer.scss'
/* base */
import './sass/foundation/base/base.scss'
import './sass/foundation/base/reset.scss'

/*
	layout
*/
import './sass/layout/l-wrap.scss'
import './sass/layout/l-modal.scss'
import './sass/layout/l-flexbox.scss'


/*
	object
*/
/* component */
import './sass/object/component/c-button.scss'
import './sass/object/component/c-img.scss'
import './sass/object/component/c-input.scss'
import './sass/object/component/c-table.scss'

/* project */

/* utility */
import './sass/object/utility/u-text.scss'
import './sass/object/utility/u-color.scss'
import './sass/object/utility/u-width.scss'
import './sass/object/utility/u-margin.scss'
import './sass/object/utility/u-padding.scss'


// /* ----------------------------------------------------------
// 	foundation
// ---------------------------------------------------------- */
// /* common */
// import './sass/foundation/common/breadcrumbs.scss'
// import './sass/foundation/common/category.scss'
// import './sass/foundation/common/footer.scss'
// import './sass/foundation/common/header.scss'
// import './sass/foundation/common/lead.scss'
// import './sass/foundation/common/nav.scss'
// import './sass/foundation/common/sidebar.scss'
// import './sass/foundation/common/page.scss'

// /* base */
// import './sass/foundation/base/base.scss'
// import './sass/foundation/base/reset.scss'


// /* ----------------------------------------------------------
// 	layout
// ---------------------------------------------------------- */
// import './sass/layout/l-alart.scss'
// import './sass/layout/l-button.scss'
// import './sass/layout/l-content.scss'
// import './sass/layout/l-flexbox.scss'
// import './sass/layout/l-list.scss'
// import './sass/layout/l-main.scss'
// import './sass/layout/l-modal.scss'
// import './sass/layout/l-scroll.scss'
// import './sass/layout/l-top.scss'
// import './sass/layout/l-wrap.scss'



// /* ----------------------------------------------------------
// 	object
// ---------------------------------------------------------- */
// /* component */
// import './sass/object/component/c-button.scss'
// import './sass/object/component/c-headline.scss'
// import './sass/object/component/c-input.scss'
// import './sass/object/component/c-scroll.scss'
// import './sass/object/component/c-img.scss'
// import './sass/object/component/c-link.scss'
// import './sass/object/component/c-list.scss'
// import './sass/object/component/c-text.scss'

// /* project */

// /* utility */
// import './sass/object/utility/u-hidden.scss'
// import './sass/object/utility/u-margin.scss'
// import './sass/object/utility/u-padding.scss'
// import './sass/object/utility/u-width.scss'
