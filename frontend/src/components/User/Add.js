import React, {useState} from 'react';
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import Form from 'react-bootstrap/Form';
import {Card, Col, Container, Row} from "react-bootstrap";
import * as yup from "yup";
import {useForm} from "react-hook-form";
import {yupResolver} from "@hookform/resolvers/yup";

const validationSchema = yup.object().shape({
    user_type: yup.string().required(),
    name: yup.string().required(),
    email: yup.string().email().required(),
    phone_number: yup.string().required(),
    password: yup.string().required('Password is required')
        .min(6, 'Password must be at least 6 characters'),
    confirm_password: yup.string()
        .required('Confirm Password is required')
        .oneOf([yup.ref('password')], 'Passwords must match')
});

const UserAdd = ({show, modalTitle, handleClose, onSubmitHandler}) => {
    const {register, handleSubmit, formState: {errors}, reset} = useForm({
        resolver: yupResolver(validationSchema),
    });

    return (
        <Modal
            show={show}
            onHide={handleClose}
            size="xl"
        >
            <Modal.Header>
                <h4 className="m-1">{modalTitle}</h4>
                <Button variant="light" className="float-right btn-fill" size="xs" onClick={handleClose}>
                    <i className="nc-icon nc-simple-remove" color="white"></i>
                </Button>
            </Modal.Header>
            <Modal.Body>
                <Row>
                    <Col md="12">
                        <Card>
                            <Card.Body>
                                <Form onSubmit={handleSubmit(onSubmitHandler)} onReset={reset}>
                                    <Row>
                                        <Col className="pr-1" md="6">
                                            <Form.Group>
                                                <label>User Type</label>
                                                <Form.Select className="form-control"
                                                             defaultValue=""
                                                             {...register("user_type")}
                                                >
                                                    <option value="">Select User Type</option>
                                                    <option value="Admin">Admin</option>
                                                    <option value="Employee">Employee</option>
                                                    <option value="Others">Others</option>
                                                </Form.Select>
                                                <p className="form-validation-error-message">{errors.user_type?.message}</p>
                                            </Form.Group>
                                        </Col>
                                        <Col className="pr-1" md="6">
                                            <Form.Group>
                                                <label>Name</label>
                                                <Form.Control
                                                    defaultValue=""
                                                    placeholder="Full Name"
                                                    type="text"
                                                    {...register("name")}
                                                ></Form.Control>
                                                <p className="form-validation-error-message">{errors.name?.message}</p>
                                            </Form.Group>
                                        </Col>
                                    </Row>
                                    <Row>
                                        <Col className="pr-1" md="6">
                                            <Form.Group>
                                                <label>Email</label>
                                                <Form.Control
                                                    defaultValue=""
                                                    placeholder="Email"
                                                    type="text"
                                                    {...register("email")}
                                                ></Form.Control>
                                                <p className="form-validation-error-message">{errors.email?.message}</p>
                                            </Form.Group>
                                        </Col>
                                        <Col className="pl-1" md="6">
                                            <Form.Group>
                                                <label>Phone Number</label>
                                                <Form.Control
                                                    defaultValue=""
                                                    placeholder="Phone Number"
                                                    type="text"
                                                    {...register("phone_number")}
                                                ></Form.Control>
                                                <p className="form-validation-error-message">{errors.phone_number?.message}</p>
                                            </Form.Group>
                                        </Col>
                                    </Row>
                                    <Row>
                                        <Col className="pr-1" md="6">
                                            <Form.Group>
                                                <label>Password</label>
                                                <Form.Control
                                                    defaultValue=""
                                                    placeholder="Password"
                                                    type="password"
                                                    {...register("password")}
                                                ></Form.Control>
                                                <p className="form-validation-error-message">{errors.password?.message}</p>
                                            </Form.Group>
                                        </Col>
                                        <Col className="pl-1" md="6">
                                            <Form.Group>
                                                <label>Confirm Password</label>
                                                <Form.Control
                                                    defaultValue=""
                                                    placeholder="Confirm Password"
                                                    type="password"
                                                    {...register("confirm_password")}
                                                ></Form.Control>
                                                <p className="form-validation-error-message">{errors.confirm_password?.message}</p>
                                            </Form.Group>
                                        </Col>
                                    </Row>
                                    <Row>
                                        <Col>
                                            <Button
                                                className="btn-fill pull-right float-right mt-2"
                                                type="submit"
                                                variant="info"
                                                size="sm"
                                            >
                                                Submit
                                            </Button>
                                            <div className="clearfix"></div>
                                        </Col>
                                    </Row>
                                </Form>
                            </Card.Body>
                        </Card>
                    </Col>
                </Row>
            </Modal.Body>
        </Modal>
    );
}
export default UserAdd;
