/**
 * @license Copyright (c) 2003-2024, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

( e => {
const { [ 'ur' ]: { dictionary, getPluralForm } } = {"ur":{"dictionary":{"Words: %0":"الفاظ: 0%","Characters: %0":"حروف: 0%","Widget toolbar":"آلہ جات برائے وجٹ","Insert paragraph before block":"پیراگراف سے پہلے کوڈ خانہ نصب کریں","Insert paragraph after block":"پیراگراف کے بعد کوڈ خانہ نصب کریں","Press Enter to type after or press Shift + Enter to type before the widget":"","Keystrokes that can be used when a widget is selected (for example: image, table, etc.)":"","Insert a new paragraph directly after a widget":"","Insert a new paragraph directly before a widget":"","Move the caret to allow typing directly before a widget":"","Move the caret to allow typing directly after a widget":"","Move focus from an editable area back to the parent widget":"","Upload in progress":"آپلوڈ جاری ہے","Undo":"رد ترمیم","Redo":"پھر سے کریں","Rich Text Editor":"خانۂ ترمیم","Edit block":"خانہ کی تدوین","Click to edit block":"","Drag to move":"","Next":"اگلا","Previous":"پچھلا","Editor toolbar":"ایڈیٹر آلہ جات","Dropdown toolbar":"آلہ جات برائے فہرست ","Dropdown menu":"","Black":"سیاہ","Dim grey":"پھیکا سرمئی","Grey":"سرمئی","Light grey":"ہلکا سرمئی","White":"سفید","Red":"سرخ","Orange":"نارنجی","Yellow":"پیلا","Light green":"ہلکا سبز","Green":"سبز","Aquamarine":"نیلگوں بلور","Turquoise":"فیروزی","Light blue":"ہلکا نیلا","Blue":"نیلا","Purple":"ارغوانی","Editor block content toolbar":"","Editor contextual toolbar":"","HEX":"","No results found":"","No searchable items":"","Editor dialog":"","Close":"","Help Contents. To close this dialog press ESC.":"","Below, you can find a list of keyboard shortcuts that can be used in the editor.":"","(may require <kbd>Fn</kbd>)":"","Accessibility":"","Accessibility help":"","Press %0 for help.":"","Move focus in and out of an active dialog window":"","MENU_BAR_MENU_FILE":"","MENU_BAR_MENU_EDIT":"ترمیم","MENU_BAR_MENU_VIEW":"","MENU_BAR_MENU_INSERT":"","MENU_BAR_MENU_FORMAT":"","MENU_BAR_MENU_TOOLS":"","MENU_BAR_MENU_HELP":"","MENU_BAR_MENU_TEXT":"","MENU_BAR_MENU_FONT":"","Editor menu bar":"","Please enter a valid color (e.g. \"ff0000\").":"","Insert table":"جدول داخل کریں","Header column":"سر ستون","Insert column left":"بائیں جانب کالم بنائیں","Insert column right":"دائیں جانب کالم بنائیں","Delete column":"ستون حذف کریں","Select column":"","Column":"ستون","Header row":"سر قطار","Insert row below":"قطار زیریں نصب کریں","Insert row above":"قطار بالا نصب کریں","Delete row":"قطار حذف کریں","Select row":"","Row":"قطار","Merge cell up":"سیل اوپر یکجا کریں","Merge cell right":"سیل دائیں طرف یکجا کریں","Merge cell down":"سیل نچلی طرف یکجا کریں","Merge cell left":"سیل بائیں طرف یکجا کریں","Split cell vertically":"سیل کی عمودی تقسیم","Split cell horizontally":"سیل کی افقی تقسیم","Merge cells":"سیل یکجا کریں","Table toolbar":"آلہ جات برائے جدول","Table properties":"","Cell properties":"","Border":"حاشیہ","Style":"","Width":"چوڑائی","Height":"اونچائی","Color":"رنگ","Background":"","Padding":"","Dimensions":"","Table cell text alignment":"","Alignment":"","Horizontal text alignment toolbar":"","Vertical text alignment toolbar":"","Table alignment toolbar":"","None":"","Solid":"","Dotted":"نقطہ دار","Dashed":"قطعہ دار","Double":"دو گنا","Groove":"","Ridge":"","Inset":"","Outset":"","Align cell text to the left":"","Align cell text to the center":"","Align cell text to the right":"","Justify cell text":"","Align cell text to the top":"","Align cell text to the middle":"","Align cell text to the bottom":"","Align table to the left":"","Center table":"","Align table to the right":"","The color is invalid. Try \"#FF0000\" or \"rgb(255,0,0)\" or \"red\".":"","The value is invalid. Try \"10px\" or \"2em\" or simply \"2\".":"","Enter table caption":"","Keystrokes that can be used in a table cell":"","Move the selection to the next cell":"","Move the selection to the previous cell":"","Insert a new table row (when in the last cell of a table)":"","Navigate through the table":"","Table":"","Styles":"انداز","Multiple styles":"متعدد انداز","Block styles":"خانہ کے انداز","Text styles":"متن کے انداز","Special characters":"","Category":"","All":"","Arrows":"","Currency":"","Latin":"","Mathematical":"","Text":"","leftwards simple arrow":"","rightwards simple arrow":"","upwards simple arrow":"","downwards simple arrow":"","leftwards double arrow":"","rightwards double arrow":"","upwards double arrow":"","downwards double arrow":"","leftwards dashed arrow":"","rightwards dashed arrow":"","upwards dashed arrow":"","downwards dashed arrow":"","leftwards arrow to bar":"","rightwards arrow to bar":"","upwards arrow to bar":"","downwards arrow to bar":"","up down arrow with base":"","back with leftwards arrow above":"","end with leftwards arrow above":"","on with exclamation mark with left right arrow above":"","soon with rightwards arrow above":"","top with upwards arrow above":"","Dollar sign":"","Euro sign":"","Yen sign":"","Pound sign":"","Cent sign":"","Euro-currency sign":"","Colon sign":"","Cruzeiro sign":"","French franc sign":"","Lira sign":"","Currency sign":"","Bitcoin sign":"","Mill sign":"","Naira sign":"","Peseta sign":"","Rupee sign":"","Won sign":"","New sheqel sign":"","Dong sign":"","Kip sign":"","Tugrik sign":"","Drachma sign":"علامتِ دراچمہ ","German penny sign":"علامت جرمن پینی","Peso sign":"علامتِ پیسو","Guarani sign":"علامتِ گوارانی","Austral sign":"","Hryvnia sign":"","Cedi sign":"","Livre tournois sign":"","Spesmilo sign":"","Tenge sign":"","Indian rupee sign":"انڈین روپیہ کی علامت","Turkish lira sign":"","Nordic mark sign":"","Manat sign":"","Ruble sign":"","Latin capital letter a with macron":"","Latin small letter a with macron":"","Latin capital letter a with breve":"","Latin small letter a with breve":"","Latin capital letter a with ogonek":"","Latin small letter a with ogonek":"","Latin capital letter c with acute":"","Latin small letter c with acute":"","Latin capital letter c with circumflex":"","Latin small letter c with circumflex":"","Latin capital letter c with dot above":"","Latin small letter c with dot above":"","Latin capital letter c with caron":"","Latin small letter c with caron":"","Latin capital letter d with caron":"","Latin small letter d with caron":"","Latin capital letter d with stroke":"","Latin small letter d with stroke":"","Latin capital letter e with macron":"","Latin small letter e with macron":"","Latin capital letter e with breve":"","Latin small letter e with breve":"","Latin capital letter e with dot above":"","Latin small letter e with dot above":"","Latin capital letter e with ogonek":"","Latin small letter e with ogonek":"","Latin capital letter e with caron":"","Latin small letter e with caron":"","Latin capital letter g with circumflex":"","Latin small letter g with circumflex":"","Latin capital letter g with breve":"","Latin small letter g with breve":"","Latin capital letter g with dot above":"","Latin small letter g with dot above":"","Latin capital letter g with cedilla":"","Latin small letter g with cedilla":"","Latin capital letter h with circumflex":"","Latin small letter h with circumflex":"","Latin capital letter h with stroke":"","Latin small letter h with stroke":"","Latin capital letter i with tilde":"","Latin small letter i with tilde":"","Latin capital letter i with macron":"","Latin small letter i with macron":"","Latin capital letter i with breve":"","Latin small letter i with breve":"","Latin capital letter i with ogonek":"","Latin small letter i with ogonek":"","Latin capital letter i with dot above":"","Latin small letter dotless i":"","Latin capital ligature ij":"","Latin small ligature ij":"","Latin capital letter j with circumflex":"","Latin small letter j with circumflex":"","Latin capital letter k with cedilla":"","Latin small letter k with cedilla":"","Latin small letter kra":"","Latin capital letter l with acute":"","Latin small letter l with acute":"","Latin capital letter l with cedilla":"","Latin small letter l with cedilla":"","Latin capital letter l with caron":"","Latin small letter l with caron":"","Latin capital letter l with middle dot":"","Latin small letter l with middle dot":"","Latin capital letter l with stroke":"","Latin small letter l with stroke":"","Latin capital letter n with acute":"","Latin small letter n with acute":"","Latin capital letter n with cedilla":"","Latin small letter n with cedilla":"","Latin capital letter n with caron":"","Latin small letter n with caron":"","Latin small letter n preceded by apostrophe":"","Latin capital letter eng":"","Latin small letter eng":"","Latin capital letter o with macron":"","Latin small letter o with macron":"","Latin capital letter o with breve":"","Latin small letter o with breve":"","Latin capital letter o with double acute":"","Latin small letter o with double acute":"","Latin capital ligature oe":"","Latin small ligature oe":"","Latin capital letter r with acute":"","Latin small letter r with acute":"","Latin capital letter r with cedilla":"","Latin small letter r with cedilla":"","Latin capital letter r with caron":"","Latin small letter r with caron":"","Latin capital letter s with acute":"","Latin small letter s with acute":"","Latin capital letter s with circumflex":"","Latin small letter s with circumflex":"","Latin capital letter s with cedilla":"","Latin small letter s with cedilla":"","Latin capital letter s with caron":"","Latin small letter s with caron":"","Latin capital letter t with cedilla":"","Latin small letter t with cedilla":"","Latin capital letter t with caron":"","Latin small letter t with caron":"","Latin capital letter t with stroke":"","Latin small letter t with stroke":"","Latin capital letter u with tilde":"","Latin small letter u with tilde":"","Latin capital letter u with macron":"","Latin small letter u with macron":"","Latin capital letter u with breve":"","Latin small letter u with breve":"","Latin capital letter u with ring above":"","Latin small letter u with ring above":"","Latin capital letter u with double acute":"","Latin small letter u with double acute":"","Latin capital letter u with ogonek":"","Latin small letter u with ogonek":"","Latin capital letter w with circumflex":"","Latin small letter w with circumflex":"","Latin capital letter y with circumflex":"","Latin small letter y with circumflex":"","Latin capital letter y with diaeresis":"","Latin capital letter z with acute":"","Latin small letter z with acute":"","Latin capital letter z with dot above":"","Latin small letter z with dot above":"","Latin capital letter z with caron":"","Latin small letter z with caron":"","Latin small letter long s":"","Less-than sign":"","Greater-than sign":"","Less-than or equal to":"","Greater-than or equal to":"","En dash":"","Em dash":"","Macron":"","Overline":"","Degree sign":"","Minus sign":"","Plus-minus sign":"","Division sign":"","Fraction slash":"","Multiplication sign":"","Latin small letter f with hook":"","Integral":"","N-ary summation":"","Infinity":"","Square root":"","Tilde operator":"","Approximately equal to":"","Almost equal to":"","Not equal to":"","Identical to":"","Element of":"","Not an element of":"","Contains as member":"","N-ary product":"","Logical and":"","Logical or":"","Not sign":"","Intersection":"","Union":"","Partial differential":"","For all":"","There exists":"","Empty set":"","Nabla":"","Asterisk operator":"","Proportional to":"","Angle":"","Vulgar fraction one quarter":"","Vulgar fraction one half":"","Vulgar fraction three quarters":"","Single left-pointing angle quotation mark":"","Single right-pointing angle quotation mark":"","Left-pointing double angle quotation mark":"","Right-pointing double angle quotation mark":"","Left single quotation mark":"","Right single quotation mark":"","Left double quotation mark":"","Right double quotation mark":"","Single low-9 quotation mark":"","Double low-9 quotation mark":"","Inverted exclamation mark":"","Inverted question mark":"","Two dot leader":"","Horizontal ellipsis":"","Double dagger":"","Per mille sign":"","Per ten thousand sign":"","Double exclamation mark":"","Question exclamation mark":"","Exclamation question mark":"","Double question mark":"","Copyright sign":"","Registered sign":"","Trade mark sign":"","Section sign":"","Paragraph sign":"","Reversed paragraph sign":"","Source":"مآخذ","Show source":"","Show blocks":"","Select all":"سب منتخب کریں","Disable editing":"تدویں غیر فعال کریں","Enable editing":"تدوین فعال کریں","Previous editable region":"","Next editable region":"","Navigate editable regions":"","Remove Format":"فارمیٹ ہٹائیں","Page break":"صفحہ کی حد","media widget":"آلۂ میڈیا","Media URL":"میڈیا یو آر ایل","Paste the media URL in the input.":"میڈیا یو آر ایل کو چسپاں کریں","Tip: Paste the URL into the content to embed faster.":"نکتہ : یو آر ایل کو جلد ضم کرنے کے لیے ربط مواد میں چسپاں کریں","The URL must not be empty.":"یو آر ایل خالی نہیں ہونا چاہیے۔","This media URL is not supported.":"میڈیا یو آر ایل  معاونت یافتہ نہیں","Insert media":"میڈیا نصب کریں","Media":"","Media toolbar":"آلہ جات برائے میڈیا","Open media in new tab":"","Numbered List":"ہندسی فہرست","Bulleted List":"غیر ہندسی فہرست","To-do List":"","Bulleted list styles toolbar":"","Numbered list styles toolbar":"","Toggle the disc list style":"","Toggle the circle list style":"","Toggle the square list style":"","Toggle the decimal list style":"","Toggle the decimal with leading zero list style":"","Toggle the lower–roman list style":"","Toggle the upper–roman list style":"","Toggle the lower–latin list style":"","Toggle the upper–latin list style":"","Disc":"","Circle":"","Square":"","Decimal":"","Decimal with leading zero":"","Lower–roman":"","Upper-roman":"","Lower-latin":"","Upper-latin":"","List properties":"","Start at":"","Invalid start index value.":"","Start index must be greater than 0.":"","Reversed order":"","Keystrokes that can be used in a list":"","Increase list item indent":"","Decrease list item indent":"","Entering a to-do list":"","Leaving a to-do list":"","Unlink":"ربط حذف کریں","Link":"ربط","Link URL":"ربط کا یو آر ایل","Link URL must not be empty.":"","Link image":"","Edit link":"ربط کی تدوین","Open link in new tab":"نئے ٹیب میں کھولیں","This link has no URL":"ربط کا کوئی یو آر ایل نہیں","Open in a new tab":"نئی ٹیب کھولیں","Downloadable":"ڈاؤنلوڈ ہو سکتا ہے","Create link":"","Move out of a link":"","Scroll to target":"","Language":"زبان","Choose language":"زبان کا انتخاب","Remove language":"زبان ہٹائیں","Increase indent":"حاشیہ بڑھائیں","Decrease indent":"حاشیہ گھٹائیں","image widget":"آلۂ عکس","Wrap text":"ملفوف متن","Break text":"متن تقسیم کریں","In line":"","Side image":"عکس بہ پہلو","Full size image":"مکمل پہمائش کا عکس","Left aligned image":"","Centered image":"","Right aligned image":"","Change image text alternative":"","Text alternative":"","Enter image caption":"","Insert image":"","Replace image":"","Upload from computer":"","Replace from computer":"","Upload image from computer":"","Image from computer":"","From computer":"","Replace image from computer":"","Upload failed":"","You have no image upload permissions.":"","Image toolbar":"آلہ جات برائے عکس","Resize image":"","Resize image to %0":"","Resize image to the original size":"","Resize image (in %0)":"","Original":"","Custom image size":"","Custom":"","Image resize list":"","Insert image via URL":"","Insert via URL":"","Image via URL":"","Via URL":"","Update image URL":"","Caption for the image":"","Caption for image: %0":"","The value must not be empty.":"","The value should be a plain number.":"","Uploading image":"","Image upload complete":"","Error during image upload":"","Image":"","HTML object":"ایچ ٹی ایم ایل آبجیکٹ","Insert HTML":"ایچ ٹی ایم ایل نصب کریں","HTML snippet":"ایچ ٹی ایم ایل تراشہ","Paste raw HTML here...":"خام ایچ ٹی ایم ایل یہاں چسپاں کریں۔۔۔","Edit source":"ماخذ کی تدوین","Save changes":"تبدیلیاں محفوظ کریں","No preview available":"نمائش دستیاب نہیں","Empty snippet content":"مندرجاتِ تراشہ خالی ہیں","Horizontal line":"افقی خط","Yellow marker":"پیلا نشان","Green marker":"سبز نشان","Pink marker":"گلابی نشان","Blue marker":"نیلا نشان","Red pen":"سرخ قلم","Green pen":"سبز قلم","Remove highlight":"غیر نمایاں کریں","Highlight":"نمایاں","Text highlight toolbar":"خانہ آلات برائے نمایاں متن","Heading":"سرخی","Choose heading":"سرخی منتخب کریں","Heading 1":"سرخی 1","Heading 2":"سرخی 2","Heading 3":"سرخی 3","Heading 4":"سرخی 4","Heading 5":"سرخی 5","Heading 6":"سرخی 6","Type your title":"عنوان ٹایپ کریں","Type or paste your content here.":"اپنا مواد یہاں ٹایپ یا چسپاں کریں.","Font Size":"فانٹ کا حجم","Tiny":"ننھا","Small":"چھوٹا","Big":"بڑا","Huge":"جسيم","Font Family":"فانٹ خاندان","Default":"طے شدہ","Font Color":"فانٹ کا رنگ","Font Background Color":"فانٹ کے پس منظر کا رنگ","Document colors":"دستاویز کے رنگ","Find and replace":"تلاش و تبدیل","Find in text…":"متن میں تلاش۔۔۔","Find":"تلاش","Previous result":"گزشتہ نتیجہ","Next result":"اگلا نتیجہ","Replace":"بدل دیں","Replace all":"تمام بدل دیں","Match case":"بڑے چھوٹے حروف کا خیال رکھیں","Whole words only":"صرف الفاظ","Replace with…":"اور اس سے تبدیل کریں...","Text to find must not be empty.":"تلاش کے لیے متن خالی نہیں ہونا چاہیے۔","Tip: Find some text first in order to replace it.":"نکتہ: تبدیل کرنے کے لیے پہلے متن کو تلاش کریں۔","Advanced options":"","Find in the document":"","Insert a soft break (a <code>&lt;br&gt;</code> element)":"","Insert a hard break (a new paragraph)":"","Cancel":"منسوخ","Clear":"","Remove color":"رنگ حذف کریں","Restore default":"طے شدہ بحال","Save":"محفوظ","Show more items":"مزید مواد کی نمائش کریں","%0 of %1":"0% میں سے 1%","Cannot upload file:":"فائل اپلوڈ نہیں ہو سکی:","Rich Text Editor. Editing area: %0":"خانۂ ترمیم۔ علاقۂ ترمیم 0%","Insert with file manager":"","Replace with file manager":"","Insert image with file manager":"","Replace image with file manager":"","File":"","With file manager":"","Toggle caption off":"","Toggle caption on":"","Content editing keystrokes":"","These keyboard shortcuts allow for quick access to content editing features.":"","User interface and content navigation keystrokes":"","Use the following keystrokes for more efficient navigation in the CKEditor 5 user interface.":"","Close contextual balloons, dropdowns, and dialogs":"","Open the accessibility help dialog":"","Move focus between form fields (inputs, buttons, etc.)":"","Move focus to the menu bar, navigate between menu bars":"","Move focus to the toolbar, navigate between toolbars":"","Navigate through the toolbar or menu bar":"","Execute the currently focused button. Executing buttons that interact with the editor content moves the focus back to the content.":"","Accept":"","Paragraph":"پیرا","Color picker":"","Insert code block":"کوڈ خانہ نصب کیرں","Plain text":"سادہ متن","Leaving %0 code snippet":"","Entering %0 code snippet":"","Entering code snippet":"","Leaving code snippet":"","Code block":"","Copy selected content":"","Paste content":"","Paste content as plain text":"","Insert image or file":"عکس یا مسل نصب کریں","Could not obtain resized image URL.":"عکس کی پیمائش تبدیل کرنے کا ربط نہیں مل سکا۔","Selecting resized image failed":"پیمائش شدہ عکس چننے میں ناکامی ہوئی","Could not insert image at the current position.":"موجودہ مقام پہ عکس نصب نہیں ہو سکا۔","Inserting image failed":"عکس نصب نہیں ہو سکا۔","Open file manager":"فائل مینیجر کھولیں","Cannot determine a category for the uploaded file.":"اپلوڈ کی گئی فائل کا ذمرے کا تعین نہیں ہو سکا","Cannot access default workspace.":"","You have no image editing permissions.":"","Edit image":"","Processing the edited image.":"","Server failed to process the image.":"","Failed to determine category of edited image.":"","Bookmark":"","Insert":"","Update":"","Edit bookmark":"","Remove bookmark":"","Bookmark name":"","Enter the bookmark name without spaces.":"","Bookmark must not be empty.":"","Bookmark name cannot contain space characters.":"","Bookmark name already exists.":"","bookmark widget":"","Block quote":"خانہ اقتباس","Bold":"جلّی","Italic":"ترچھا","Underline":"ترچھا","Code":"کوڈ","Strikethrough":"خط کشیدہ","Subscript":"زير نوشت","Superscript":"بالا نوشت","Italic text":"","Move out of an inline code style":"","Bold text":"","Underline text":"","Strikethrough text":"","Saving changes":"خودکار محفوظ","Revert autoformatting action":"","Align left":"بائیں سیدھ","Align right":"دائیں سیدھ","Align center":"درمیانی سیدھ","Justify":"برابر سیدھ","Text alignment":"متن کی سیدھ","Text alignment toolbar":"خانہ آلات برائے سیدھ"},getPluralForm(n){return (n != 1);}}};
e[ 'ur' ] ||= { dictionary: {}, getPluralForm: null };
e[ 'ur' ].dictionary = Object.assign( e[ 'ur' ].dictionary, dictionary );
e[ 'ur' ].getPluralForm = getPluralForm;
} )( window.CKEDITOR_TRANSLATIONS ||= {} );
