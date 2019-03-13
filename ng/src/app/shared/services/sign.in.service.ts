import {Injectable} from "@angular/core";

import {SignInService} from "";
import {SignOutService} from "";
import {EventService} from "";
import {EventTagService} from "";
import {TagService} from "";

import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable ()
export class ApiService {

	constructor(protected http : HttpClient ) {}

	//define the API endpoint
	private apiUrl = "https://bootcamp-coders.cnm.edu/~wsalmons/capstone-project/public_html/api/";


	// call to the sign-in API and create the sign-in
	signInAdmin(admin : Admin) : Observable<Status> {
		return(this.http.post<Status>(this.apiUrl, admin));
	}

	// call to the tweet API and get a tweet object based on its Id
	getUser(userId : string) : Observable<User> {
		return(this.http.get<User>(this.apiUrl + userId));

	}

	// call to the API and get an array of tweets based off the profileId
	getDetailedUser(userId : string) : Observable<UserPosts[]> {
		return(this.http.get<UserPosts[]>(this.apiUrl + "?postUserId=" + userId ));

	}

	//call to the API and get an array of all the tweets in the database
	getAllUsers() : Observable<User> {
		return(this.http.get<User>(this.apiUrl));

	}




}