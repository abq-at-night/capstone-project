import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs";
import {Event} from "../interfaces/event";
import {Status} from "../interfaces/status";

@Injectable()
export class EventService {
	private eventUrl = "api/event/";

	constructor(protected http: HttpClient) {}

	deleteEvent(eventId: string) : Observable<Status> {
		return(this.http.delete<Status>(this.eventUrl +eventId));
	}

	getAllEvents() : Observable<any[]> {
		return(this.http.get<any[]>(this.eventUrl));
	}

	getEvent(eventId: string) : Observable<Event> {
		return(this.http.get<Event>(this.eventUrl + eventId));
	}

	createEvent(event: Event) : Observable<Status> {
		return(this.http.post<Status>(this.eventUrl, event));
	}

	editEvent(event: Event) : Observable<Status> {
		return(this.http.put<Status>(this.eventUrl + event.eventId, event));
	}

	// getEventsByEventDistance(lat: number, lng: number, distance: number) {
	// 	return this.http.getEvent()
	// }

}