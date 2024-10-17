import './bootstrap';
import 'flowbite';

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import multiMonthPlugin from '@fullcalendar/multimonth';

import { DotLottie } from '@lottiefiles/dotlottie-web';


window.Calendar = Calendar;
window.dayGridPlugin = dayGridPlugin;
window.timeGridPlugin = timeGridPlugin;
window.listPlugin = listPlugin;
window.multiMonthPlugin = multiMonthPlugin;

window.DotLottie = DotLottie;
