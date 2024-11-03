import { NextComponentType, NextPageContext } from "next";
import Head from "next/head";

import { Form } from "../../components/vehicle/Form";

const Page: NextComponentType<NextPageContext> = () => (
  <div>
    <div>
      <Head>
        <title>Create Vehicle</title>
      </Head>
    </div>
    <Form />
  </div>
);

export default Page;
