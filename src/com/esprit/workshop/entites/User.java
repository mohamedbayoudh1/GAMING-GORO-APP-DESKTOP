package com.esprit.workshop.entites;

import java.util.Date;

public class User {
    private int id;
    private String nom;
    private String prenom;
    private String email;
    private String password;
    private Date date_naissance;
    private float point;
    private String phone;
    private String about;
    private String photo_profile;
    private String photo_couverture;
    private boolean ban;
    private boolean statut;
    private boolean validEmail;

    public User(String nom, String prenom, String email, String password, Date date_naissance, float point, String phone, String about, String photo_profile, String photo_couverture) {
        this.nom = nom;
        this.prenom = prenom;
        this.email = email;
        this.password = password;
        this.date_naissance = date_naissance;
        this.point = point;
        this.phone = phone;
        this.about = about;
        this.photo_profile = photo_profile;
        this.photo_couverture = photo_couverture;
        this.ban = false;
        this.statut = false;
        this.validEmail = false;
    }

    public User() {
        this.ban = false;
        this.statut = false;
        this.validEmail = false;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getPrenom() {
        return prenom;
    }

    public void setPrenom(String prenom) {
        this.prenom = prenom;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public Date getDate_naissance() {
        return date_naissance;
    }

    public void setDate_naissance(Date date_naissance) {
        this.date_naissance = date_naissance;
    }

    public float getPoint() {
        return point;
    }

    public void setPoint(float point) {
        this.point = point;
    }

    public String getPhone() {
        return phone;
    }

    public void setPhone(String phone) {
        this.phone = phone;
    }

    public String getAbout() {
        return about;
    }

    public void setAbout(String about) {
        this.about = about;
    }

    public String getPhoto_profile() {
        return photo_profile;
    }

    public void setPhoto_profile(String photo_profile) {
        this.photo_profile = photo_profile;
    }

    public String getPhoto_couverture() {
        return photo_couverture;
    }

    public void setPhoto_couverture(String photo_couverture) {
        this.photo_couverture = photo_couverture;
    }

    public boolean isBan() {
        return ban;
    }

    public void setBan(boolean ban) {
        this.ban = ban;
    }

    public boolean isStatut() {
        return statut;
    }

    public void setStatut(boolean statut) {
        this.statut = statut;
    }

    public boolean isValidEmail() {
        return validEmail;
    }

    public void setValidEmail(boolean validEmail) {
        this.validEmail = validEmail;
    }

    @Override
    public String toString() {
        return
                "id=" + id +
                        ", nom='" + nom + '\'' +
                        ", prenom='" + prenom + '\'' +
                        ", email='" + email + '\'' +
                        ", password='" + password + '\'' +
                        ", date_naissance=" + date_naissance +
                        ", point=" + point +
                        ", phone='" + phone + '\'' +
                        ", about='" + about + '\'' +
                        ", photo_profile='" + photo_profile + '\'' +
                        ", photo_couverture='" + photo_couverture + '\'' +
                        ", ban=" + ban +
                        ", statut=" + statut +
                        ", validEmail=" + validEmail ;
    }

}
