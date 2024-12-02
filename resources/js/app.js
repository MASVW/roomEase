import './bootstrap';
import 'flowbite';


import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import multiMonthPlugin from '@fullcalendar/multimonth';
import interactionPlugin from '@fullcalendar/interaction';

import lottie from 'lottie-web';

window.Calendar = Calendar;
window.dayGridPlugin = dayGridPlugin;
window.timeGridPlugin = timeGridPlugin;
window.listPlugin = listPlugin;
window.multiMonthPlugin = multiMonthPlugin;
window.interactionPlugin = interactionPlugin;
window.Datepicker = Datepicker;

window.lottie = lottie;





